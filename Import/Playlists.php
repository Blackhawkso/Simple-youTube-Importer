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
 * Playlists
 *
 * @package Import
 * @author Phil Thompson <phil@bhsowebdesign.com>
 * @link http://www.bhsowebdesign.com
 */
class Playlists
{
    /**
     * getPlaylists
     *
     * @param string $channel_name
     * @return array
     */
    public function getPlaylists($channel_name) {
        $url = 'http://gdata.youtube.com/feeds/api/users/' . $channel_name . '/playlists?v=2&prettyprint=true';

        $xml = simplexml_load_file($url);

        $playlists = [];

        copy($url, './playlist.xml');

        foreach ($xml->entry as $entry) {

            print $entry->content->attributes()['src'] . "\n\n\n";

            $playlists[] = $entry->content->attributes()['src'];
        }

        print "Playlists imported\n\n\n";

        print "-----------------------------------------------------------------\n\n\n";

        return $playlists;
    }
}
