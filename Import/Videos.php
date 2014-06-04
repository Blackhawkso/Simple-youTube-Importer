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
 * Videos
 *
 * @package Import
 * @author Phil Thompson <phil@bhsowebdesign.com>
 * @link http://www.bhsowebdesign.com
 */
class Videos
{
    /**
     * $playlists
     *
     * @var array
     */
    protected $playlists;

    /**
     * setPlaylists
     *
     * @param array $playlists
     * @return \Import\Videos
     */
    public function setPlaylists($playlists)
    {
        $this->playlists = $playlists;

        return $this;
    }

    /**
     * getPlaylists
     *
     * @return array
     */
    public function getPlaylists()
    {
        return $this->playlists;
    }

    /**
     * getVideosData
     *
     * Due to a restriction in the youTube API you can only get a maximum of
     * 500 videos in blocks of 50 from each playlist
     *
     * @return void
     */
    public function getVideosData()
    {
        $playlist_number = 1;

        foreach ($this->getPlaylists() as $url) {
            $i = 1;

            while ($i <= 500) {

                /**
                 * Switch from https to http because it can cause issues sometimes
                 */
                $new_url = substr($url,4);

                $url_xml = 'http' . $new_url . '&start-index=' . $i . '&max-results=50&orderby=published&prettyprint=true';

                $xml = simplexml_load_file($url_xml);
                echo "--------------------------------------------------------------\n\n\n";
                echo $url_xml . "\n\n";

                if (count($xml->entry) != 0) {
                    switch ($i) {
                        case 1:
                            $file = 'output/' . $playlist_number . '_001.xml';
                            break;
                        case 51:
                            $file = 'output/' . $playlist_number . '_051.xml';
                            break;
                        default:
                            $file = 'output/' . $playlist_number . '_' . $i . '.xml';
                    }

                    copy($url_xml, $file);

                    echo "Made file " . $file . "\n\n\n";
                }
                $i = $i + 50;
            }
            $playlist_number++;
        }
    }
}
