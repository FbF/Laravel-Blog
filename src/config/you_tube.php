<?php

/**
 * Config settings for the YouTube Video
 */
return array(

	/**
	 * Whether the YouTube field is shown in the administrator config, and whether it's set for the seed
	 */
	'show' => true,

	/**
	 * YouTube Embed Player code used if an item has a You Tube Video ID set
	 * instead of a Main Image. Changing the settings will apply to all items that
	 * have a You Tube Video on them. The placeholder "%YOU_TUBE_VIDEO_ID%" is
	 * replaced with the You Tube Video ID in the database for this item.
	 */
	'embed_code' => '<iframe width="560" height="315" src="//www.youtube.com/embed/%YOU_TUBE_VIDEO_ID%?rel=0" frameborder="0" allowfullscreen></iframe>',

	/**
	 * YouTube Thumbnail code used if an item has a You Tube Video ID set instead of a Main Image. Changing the
	 * settings will apply to all entries on the index pages for items that have a You Tube Video. The
	 * placeholder "%YOU_TUBE_VIDEO_ID%" is replaced with the You Tube Video ID in the database for this item.
	 */
	'thumbnail_code' => '<img src="//img.youtube.com/vi/%YOU_TUBE_VIDEO_ID%/mqdefault.jpg" width="200" height="150" />',

);