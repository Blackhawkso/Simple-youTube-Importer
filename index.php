<?php

/**
 * This is best run as a cron job.
 *
 * just add the command of 'php index.php' to your cron system
 */

require_once './SplClassLoader.php';
require_once './config.php';

$classLoader = new SplClassLoader('Import', __DIR__);
$classLoader->register();

use Import\Playlists;
use Import\Process;
use Import\Videos;

$playlist_class = new Playlists();
$process_class = new Process();
$videos_class = new Videos();

print "Playlists import started\n\n\n";

print "-----------------------------------------------------------------\n\n\n";

$playlists = $playlist_class->getPlaylists($config['channel_name']);

print "Playlists Imported\n\n\n";

print "------------------------------------------------\n\n\n";

$videos_class->setPlaylists($playlists);

print "Videos import started\n\n\n";

print "-----------------------------------------------------------------\n\n\n";

$videos_class->getVideosData();

print "Videos Imported\n\n\n";

print "------------------------------------------------\n\n\n";

print "Processing data\n\n\n";

$process_class->processData();

print "Finished";
