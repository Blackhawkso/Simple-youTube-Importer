<?php

/**
 * Simple youTube Importer
 * Copyright (C) 2014  Phil Thompson
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Import;

/**
 * Process
 *
 * @package Import
 * @author Phil Thompson <phil@bhsowebdesign.com>
 * @link http://www.bhsowebdesign.com
 */
class Process
{
    /**
     * processData
     *
     * @return string
     */
    public function processData()
    {
        $dir = './output/';

        $files = array_diff(scandir($dir), ['..', '.', 'playlist.json', 'videos.json']);

        $playlist = [];

        $arr = [];

        foreach ($files as $file) {
            if ($xml = simplexml_load_file($dir . $file)) {

                $play_title = $xml->title;

                $acro = "";

                $words = explode(" ", $play_title);

                foreach ($words as $w) {
                    $acro .= $w[0];
                }

                $playlist[$acro] = $xml->title;

                foreach ($xml->entry as $entry) {
                    if ($entry->title != 'Private video') {

                        $video_url = $entry->content->attributes()['src'];

                        $url_parsed = parse_url($video_url);

                        $arr[substr($url_parsed['path'],3)] = [
                            'id' => substr($url_parsed['path'],3),
                            'title' => $entry->title,
                            'link' => $video_url,
                            'date' => strtotime($entry->published),
                            'playlist' => $xml->title
                        ];
                    }
                }
            }
        }

        usort($arr, function ($a, $b) {
            $a = $a['date'];
            $b = $b['date'];
            return ($a == $b) ? 0 : (($a < $b) ? -1 : 1);
        });

        $array = array_reverse($arr);

        $json = json_encode($array);

        $output_file = $dir . 'videos.json';

        $f = fopen($output_file, 'w');
        fwrite($f, $json);
        fclose($f);

        ksort($playlist);

        $json2 = json_encode($playlist);

        $output_file2 = $dir . 'playlist.json';

        $f2 = fopen($output_file2, 'w');
        fwrite($f2, $json2);
        fclose($f2);

        echo "Done!\n\n\n";
    }
}
