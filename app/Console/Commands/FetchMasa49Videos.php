<?php

namespace App\Console\Commands;

use App\Http\Controllers\HomeController;
use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Videos;

class FetchMasa49Videos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetchmasa49videos {page_no=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch posts from WordPress API and store them in the Videos model';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $max_pages = 4041; // Starting maximum page number

        // $max_pages = 4350; // Maximum number of pages to loop through
        $max_pages = (int)$this->argument('page_no'); // Starting page number
        $total_count = 1;
        $min_pages = 1;
        for ($current_page = $max_pages; $current_page >= $min_pages; $current_page--) {
            $scrap_url = "https://masa49.com/page/" . $current_page;
            // $videos = $this->get_video_data($scrap_url);
            $videos = HomeController::get_video_data($scrap_url);
            if ($videos == false) {
                $this->info("error on page = " . $current_page);
                return false;
                exit;
            } else {
                $this->info("success on page = " . $current_page);
                foreach ($videos as $post) {
                    $single_video_detail =  HomeController::get_video_detail($post['url']);
                    $category_id = "";
                    if ($single_video_detail['category'] != "") {
                        $category = Category::where('title', $single_video_detail['category'])->first();
                        if ($category) {
                            $category_id = $category['id'];
                        }
                    }
                    // dd($category, $single_video_detail, $category_id);
                    $db_slug = str_replace('https://masa49.com/', '', $post['url']);
                    Videos::updateOrCreate(
                        [
                            'slug' => $db_slug,
                            'platform' => 'masa49.com'
                        ],
                        [
                            'title' => $post['title'] ?? "",
                            'video_url' => $single_video_detail['download_url'] ?? "",
                            'category_id' => $category_id,
                            'thumbnail' => $post['thumbnail'] ?? "",
                            'duration' => $post['time'] ?? "",
                            'added_on' => $post['view'] ?? "",
                            'status' => 'active'
                        ]
                    );
                    $this->info("total count : " . $total_count);
                    $total_count++;
                }
            }
        }
    }
    function get_video_data($url)
    {
        $html_content = $this->fetch_url($url);
        $html = str_get_html($html_content);
        $videos = [];
        if ($html != false && $html->find('.video_list .video')) {
            foreach ($html->find('.video_list .video') as $video_element) {
                $title = $video_element->find('.title', 0)->plaintext ?? "";
                $video_url = $video_element->find('a', 0)->href ?? "";
                $thumbnail_url = $video_element->find('img', 0)->src ?? "";
                $time = $video_element->find('.time', 0)->plaintext ?? "";
                $view = $video_element->find('.view', 0)->plaintext ?? "";
                $videos[] = [
                    'title' => $title,
                    'url' => $video_url,
                    'thumbnail' => $thumbnail_url,
                    'time' => $time,
                    'view' => $view
                ];
            }
            return $videos;
        } else {
            return false;
        }
    }
    function fetch_url($url)
    {
        $ch = curl_init(); // Initialize cURL session
        curl_setopt($ch, CURLOPT_URL, $url); // Set the URL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects if any
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0'); // Set user agent to mimic a real browser
        $response = curl_exec($ch); // Execute the cURL request
        curl_close($ch); // Close the cURL session

        // Check if there was an error during the request
        if ($response === false) {
            echo "cURL Error: " . curl_error($ch);
            return false;
        }
        return $response; // Return the fetched content
    }
}
