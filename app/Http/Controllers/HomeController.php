<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Videos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

include('simple_html_dom.php');

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search = "";
        if (isset($request->s)) {
            $search = $request->s;
        }
        if ($request->get('page_no') && $request->get('page_no') != "") {
            return redirect()->route('page', $request->get('page_no'));
        }
        $pageNo = $request->get('page_no') ?? 1;
        $perPage = 15;
        $videos = Videos::where('status', 'active')
            ->when($search != '', function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orwhere('id', $search);
            })
            ->orderBy('id', 'desc')
            ->forPage($pageNo, $perPage)
            ->get();
        $totalRecords = Videos::where('status', 'active')
            ->when($search != '', function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orwhere('id', $search);
            })->count();
        $maxPage = (int) ceil($totalRecords / $perPage);
        return view('welcome', compact('videos', 'maxPage'));
    }
    public function page(Request $request, $page_no)
    {
        if ($request->get('page_no') && $request->get('page_no') != "") {
            return redirect()->route('page', $request->get('page_no'));
        }
        $pageNo = $request->get('page_no') ?? $page_no;
        $perPage = 15;
        $videos = Videos::where('status', 'active')
            ->orderBy('id', 'desc')
            ->forPage($pageNo, $perPage)
            ->get();
        $totalRecords = Videos::where('status', 'active')->count();
        $maxPage = (int) ceil($totalRecords / $perPage);
        if ($videos) {
            return view('welcome', compact('videos', 'page_no', 'maxPage'));
        } else {
            return redirect()->route('home');
        }
    }
    public function category(Request $request, $category_name, $page_no = 1)
    {
        if ($request->get('page_no') && $request->get('page_no') != "") {
            return redirect()->route('category', [$category_name, $request->get('page_no')]);
        }
        $category_data = Category::where('slug', $category_name)->first();
        if ($category_data) {
            $pageNo = $request->get('page_no') ?? $page_no;
            $perPage = 15;
            $videos = Videos::where('status', 'active')
                ->orderBy('id', 'desc')
                ->where('category_id', $category_data->id)
                ->forPage($pageNo, $perPage)
                ->get();
            $totalRecords = Videos::where('status', 'active')->where('category_id', $category_data->id)->count();
            $maxPage = (int) ceil($totalRecords / $perPage);
            if ($videos) {
                return view('welcome', compact('videos', 'category_name', 'page_no', 'maxPage'));
            } else {
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('home');
        }
    }
    function video_detail(Request $request, $video_url)
    {
        $video = Videos::where('status', 'active')
            ->where('slug', $video_url . '/')
            ->first();
        $related_videos = Videos::where('status', 'active')
            ->inRandomOrder()
            ->limit(9)
            ->get();
        if ($video) {
            return view('video_detail', compact('video', 'related_videos'));
        } else {
            return redirect()->route('home');
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
