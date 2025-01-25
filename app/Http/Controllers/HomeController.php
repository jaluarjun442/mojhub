<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

include('simple_html_dom.php');

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if (isset($request->s)) {
            $search = urlencode($request->s);
            $scrap_url = "https://masa49.com/?s=" . $search;
        } else {
            $search = '';
            $scrap_url = "https://masa49.com";
        }
        $videos = $this->get_video_data($scrap_url);
        if ($videos != false) {
            return view('welcome', compact('videos'));
        } else {
            return redirect()->to($request->fullUrl());
        }
    }
    public function page(Request $request, $page_no)
    {
        $scrap_url = "https://masa49.com/page/" . $page_no;
        $videos = $this->get_video_data($scrap_url);
        if ($videos != false) {
            return view('welcome', compact('videos', 'page_no'));
        } else {
            return redirect()->to($request->fullUrl());
        }
    }
    public function category(Request $request, $category_name, $page_no = 1)
    {
        $scrap_url = "https://masa49.com/category/" . $category_name . '/page/' . $page_no;
        $videos = $this->get_video_data($scrap_url);
        if ($videos != false) {
            return view('welcome', compact('videos', 'category_name', 'page_no'));
        } else {
            return redirect()->to($request->fullUrl());
        }
    }
    function video_detail(Request $request, $video_url)
    {
        $base_url = "https://masa49.com";
        $video_url = $base_url . '/' . $video_url;
        $video = $this->get_video_detail($video_url);
        if ($video == false) {
            return redirect()->to($request->fullUrl());
        } else {
            return view('video_detail', compact('video'));
        }
    }
    public static function get_video_data($url)
    {
        $html_content = self::fetch_url($url);
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
    public static function get_video_detail($url)
    {
        $html_content = self::fetch_url($url);
        $html = str_get_html($html_content);
        $related_videos = [];
        if ($html != false && $html->find('.post_single h1.title', 0)) {
            $title = $html->find('.post_single h1.title', 0)->plaintext;
            $category = $html->find('.tag', 0)->plaintext ?? "";
            $download_url = '';
            foreach ($html->find('.downLink a') as $button) {
                $href = $button->href;
                if (strpos($href, 'intent:') === false) {
                    $download_url = $href;
                    break;
                }
            }
            foreach ($html->find('.video_list .video') as $video_element) {
                $title = $video_element->find('.title', 0)->plaintext ?? "";
                $video_url = $video_element->find('a', 0)->href ?? "";
                $thumbnail_url = $video_element->find('img', 0)->src ?? "";
                $time = $video_element->find('.time', 0)->plaintext ?? "";
                $view = $video_element->find('.view', 0)->plaintext ?? "";
                $related_videos[] = [
                    'title' => $title,
                    'url' => $video_url,
                    'thumbnail' => $thumbnail_url,
                    'time' => $time,
                    'view' => $view
                ];
            }
            return [
                'title' => $title,
                'download_url' => $download_url,
                'url' => $url,
                'category' => $category,
                'related_videos' => $related_videos
            ];
        } else {
            return false;
        }
    }
    public static function fetch_url($url)
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
