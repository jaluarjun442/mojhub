<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

include('simple_html_dom.php');

class HomeController extends Controller
{
    public function index()
    {
        $scrap_url = "https://masa49.com";
        $videos = $this->get_video_data($scrap_url);
        return view('welcome', compact('videos'));
    }
    public function page($page_no)
    {
        $scrap_url = "https://masa49.com/page/".$page_no;
        $videos = $this->get_video_data($scrap_url);
        return view('welcome', compact('videos','page_no'));
    }
    function video_detail($video_url)
    {
        $base_url = "https://masa49.com";
        $video_url = $base_url .'/'. $video_url;
        // Fetch video details
        $video_detail = $this->get_video_detail($video_url);
        return view('video_detail', compact('video_detail'));
    }
    function get_video_data($url)
    {
        // $url = "https://masa49.com"; // Base URL
        $html_content = $this->fetch_url($url);
        $html = str_get_html($html_content);
        $videos = [];

        // Find all the video items on the page
        foreach ($html->find('.video_list .video') as $video_element) {
            $title = $video_element->find('.title', 0)->plaintext;
            $video_url = $video_element->find('a', 0)->href;
            $thumbnail_url = $video_element->find('img', 0)->src;

            // Add the video details to the array
            $videos[] = [
                'title' => $title,
                'url' => $video_url,
                'thumbnail' => $thumbnail_url
            ];
        }

        return $videos;
    }

    // Function to fetch video details
    function get_video_detail($url)
    {
        $html_content = $this->fetch_url($url);

        // Parse the HTML content with simple_html_dom
        $html = str_get_html($html_content);

        // Extract video title
        $title = $html->find('.post_single h1.title', 0)->plaintext;

        // Extract the download URL (skip the "intent" URL)
        $download_url = '';
        foreach ($html->find('.downLink a') as $button) {
            $href = $button->href;
            // Skip the "intent" URL
            if (strpos($href, 'intent:') === false) {
                $download_url = $href;
                break;
            }
        }

        return [
            'title' => $title,
            'download_url' => $download_url,
            'url' => $url
        ];
    }

    // Function to fetch the content of a URL using cURL
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
