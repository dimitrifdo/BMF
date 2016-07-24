<?php
/*
Template Name: 2016 Program listing
*/

 get_header(); ?>

<?php
	$bgUrl = the_field('background-image');
	if (get_field('background_image')) : ?>

		<div id="content-container"
		style="background-image:url('<?php echo the_field('background_image'); ?>');
		">

		<!--<div id="content-container"
		style="background-image:url('<?php echo the_field('background_image'); ?>');">-->

	<?php else: ?>

		<div id="content-container">

	<?php endif ?>


<div id="content-inner-container">


<!-- START OF ACT FILTER -->
	<div id="filter-container">
		<?php

			$args = array('post_type'=>'artists',
						  'posts_per_page'=>-1);
			$artistQ = new WP_query($args);

			$dateArray = array();
			$actArray = array();
			$venArray = array();
		?>

		<?php if ( $artistQ->have_posts() ) :  while ( $artistQ->have_posts() ) : $artistQ->the_post(); ?>

<!-- PUSH ARTIST SHOWDATE, NAME AND VENUE INTO SEPERATE AREAS -->
			<?php
				if ( get_field('show_date') ) {
					$rawDate = get_field('show_date');
					array_push($dateArray, $rawDate);
					$dateArrayFinal = array_unique($dateArray);
					sort($dateArrayFinal);
				}
			?>

			<?php
				if ( get_field('artist_name') ) {
					$rawAct = get_field('artist_name');
					array_push($actArray, $rawAct);
					sort($actArray);
				}
			?>

			<?php
				if ( get_field('venue') ) {
					$rawVenue = get_field('venue');
					array_push($venArray, $rawVenue);
					$venArrayFinal = array_unique($venArray);
					sort($venArray);
				}
			?>
<!-- -->

		<?php endwhile; else : ?>

		<?php endif; ?>


<!-- SET MIX CONTROLLERS USING ARRAYS -->
		<select class="mix-controller">
			<option value="all">Select a date</option>
		<?php

			foreach ($dateArrayFinal as $dKey => $dVal) : ?>

			<?php
				$parsedDate = new DateTime($dVal, $timeZone);
				$timeZone = new DateTimeZone('Australia/Melbourne');
				$formatedDate = $parsedDate->format('l, jS F');
			?>

			<option value="<?php echo ".$dVal"; ?>"><?php echo $formatedDate; ?></option>

		<?php endforeach ?>

		</select>




		<select class="mix-controller">
			<option value="all">Select a venue</option>

		<?php foreach ($venArrayFinal as $vKey => $vVal) : ?>

			<option value="<?php

			$venEdit = preg_replace('/\s+/', '', $vVal);
			echo ".$venEdit"; ?>"><?php echo $vVal; ?></option>

		<?php endforeach ?>

		</select>





		<select class="mix-controller">
			<option value="all">Select an act</option>

		<?php foreach ($actArray as $aKey => $aVal) : ?>

			<option value="<?php

			$actEdit = preg_replace('/\s+/', '', $aVal);
			echo ".$actEdit"; ?>"><?php echo $aVal; ?></option>

		<?php endforeach ?>

		</select>




		<button class="filterReset">
			RESET
		</button>

	</div>


<!-- CONTENT GOES HERE -->

<div id="lineup-container">

  <!-- LOAD ALL ARTIST LINKS -->

<?php

$args = array('post_type'=>'artists',
			  'posts_per_page' => '-1',
			  'post__not_in' => array(1075, 1076),
			  'meta_key' => 'order_of_post',
			  'orderby' => 'meta_value_num',
			  'order' => 'ASC');
$artistQ = new WP_query($args) ;

?>

<?php if ( $artistQ->have_posts() ) : while ( $artistQ->have_posts() ) : $artistQ->the_post(); ?>



<?php
	$artistClass = preg_replace('/\s+/', '', get_field('artist_name'));
	$venueClass = preg_replace('/\s+/', '', get_field('venue'));
?>


<div class="lineup-item mix <?php echo the_field('show_date'); ?> <?php echo $artistClass; ?> <?php echo $venueClass; ?>">

	<!-- START OF TITLE DIV -->
	<div
		<?php if( get_field('support_act_alternative') ) : ?>
				class="lineup-title-support"
		<?php else : ?>
				class="lineup-title"
		<?php endif ?>
	><!-- END OF TITLE DIV -->



	<?php $supportActAlt = get_field('support_act_alternative'); if ($supportActAlt) : ?>


		<a href="<?php the_field('support_act_alternative_link'); ?>" class="fittextTitle lineup-title-a"><?php the_title(); ?>


		<?php if ( get_field('artist_country') ) : ?>

		<span style="font-size:15px;"><?php echo ('('); the_field('artist_country'); echo (')');  ?></span>

		<?php endif; ?>


		</a></div>


	<?php else : ?>


		<a href="<?php the_permalink(); ?>" class="fittextTitle lineup-title-a"><?php the_title(); ?>


		<?php if ( get_field('artist_country') ) : ?>

		<span style="font-size:15px;"><?php echo ('('); the_field('artist_country'); echo (')');  ?></span>

		<?php endif; ?>



		</a></div>

	<?php endif; ?>






	<?php $supportActAlt = get_field('support_act_alternative'); if ($supportActAlt) : ?>

		<a href="<?php the_field('support_act_alternative_link'); ?>">
		<div class="lineup-image"
		style="background-image:url('<?php the_field('artist_main_image'); ?>');">

			<div class="artist-tag-container"><em><?php the_field('artist_tagline'); ?></em></div>

		</div>
		</a>

	<?php else : ?>
		<a href="<?php the_permalink(); ?>">
		<div class="lineup-image"
		style="background-image:url('<?php the_field('artist_main_image'); ?>');">

			<div class="artist-tag-container"><em><?php the_field('artist_tagline'); ?></em></div>

		</div>
		</a>
	<?php endif; ?>




	<div class="lineup-date">
		<?php
			$lastShow = get_field("last_show_date");
			$theDate = get_field('show_date');
			$theLastDate = get_field('last_show_date');
			$theTimeZone = new DateTimeZone('Australia/Melbourne');

			$newDate = new DateTime($theDate, $theTimeZone);
			$newLastDate = new DateTime($theLastDate, $theTimeZone);

		if ($lastShow) : ?>
			<?php echo $newDate->format('jS'); ?> - <?php echo $newLastDate->format('jS F'); ?> @ <?php the_field('act_time'); ?>

		<?php else : ?>
			<?php echo $newDate->format('l, jS F'); ?> @ <?php the_field('act_time'); ?>
		<?php endif; ?>

	</div>
	<div class="lineup-links">

	<?php $supportActAlt = get_field('support_act_alternative'); if ($supportActAlt) : ?>
		<a href="<?php the_field('support_act_alternative_link'); ?>">READ MORE</a>
	<?php else : ?>
		<a href="<?php the_permalink(); ?>">READ MORE</a>
	<?php endif; ?>

		<a href="<?php the_field('artist_ticket_link'); ?>">BUY TICKETS</a>

	</div>
</div>



<?php endwhile; else : ?>
	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>

<?php endif; ?>





<div class="lineup-item mix">

		<!-- START OF TITLE DIV -->
	<div class="lineup-title-support"><!-- END OF TITLE DIV -->


	<a href="http://www.brunswickbeethovenfestival.org.au/" class="fittextTitle lineup-title-a">
	BRUNSWICK BEETHOVEN FESTIVAL 2016
	</a></div>


	<div class="lineup-image"
	style="background:url('http://www.brunswickmusicfestival.com.au/wp-content/themes/BMF%20WP/img/stage-imgs/BBF_TILE.jpg');
	background-size:100%;-o-background-size:100%;-ms-background-size:100%;-moz-background-size:100%;-webkit-background-size:100%;
	background-color:#712647;">


	</div>
	<div class="lineup-date">
		<span>&nbsp;</span>

	</div>
	<div class="lineup-links">

		<a style="width:100% !important;" href="http://www.brunswickbeethovenfestival.org.au/">MORE INFO</a>

	</div>
</div>




<div class="lineup-item mix">

		<!-- START OF TITLE DIV -->
	<div class="lineup-title-support"><!-- END OF TITLE DIV -->


	<a href="https://brunswickmusicfestival.tickets.red61.com/performances.php?eventId=2136:201" class="fittextTitle lineup-title-a">
	Venue Pass
	</a></div>


	<div class="lineup-image"
	style="background:url('http://www.brunswickmusicfestival.com.au/wp-content/uploads/2015/11/venuepass-featured.jpg');
	background-size:100%;-o-background-size:100%;-ms-background-size:100%;-moz-background-size:100%;-webkit-background-size:100%;
	background-color:#712647;">


	</div>
	<div class="lineup-date">
		<span>&nbsp;</span>

	</div>
	<div class="lineup-links">

		<a style="width:100% !important;" href="https://brunswickmusicfestival.tickets.red61.com/performances.php?eventId=2136:201">BUY A VENUE PASS</a>

	</div>
</div>



<div class="lineup-item mix">

	<!-- START OF TITLE DIV -->
	<div class="lineup-title-support"><!-- END OF TITLE DIV -->


	<a href="https://brunswickmusicfestival.tickets.red61.com/vouchers.php" class="fittextTitle lineup-title-a">
	Gift Voucher
	</a></div>


	<div class="lineup-image"
	style="background:url('http://www.brunswickmusicfestival.com.au/wp-content/uploads/2015/11/giftvoucher-featured.jpg');
	background-size:100%;-o-background-size:100%;-ms-background-size:100%;-moz-background-size:100%;-webkit-background-size:100%;
	background-color:#e2a93e;">


	</div>
	<div class="lineup-date">
		<span>&nbsp;</span>

	</div>
	<div class="lineup-links">

		<a style="width:100% !important;" href="https://brunswickmusicfestival.tickets.red61.com/vouchers.php">BUY A GIFT VOUCHER</a>

	</div>
</div>

<div class="lineup-item mix">

	<!-- START OF TITLE DIV -->
	<div class="lineup-title-support"><!-- END OF TITLE DIV -->


	<a href="http://www.brunswickmusicfestival.com.au/music-for-the-people/" class="fittextTitle lineup-title-a">
	Music for the People
	</a></div>


	<div class="lineup-image"
	style="background:url('http://www.brunswickmusicfestival.com.au/wp-content/uploads/2016/01/QuarterStreetOrchestra1.jpg');
	background-size:100%;-o-background-size:100%;-ms-background-size:100%;-moz-background-size:100%;-webkit-background-size:100%;
	background-color:#e2a93e;">


	</div>
	<div class="lineup-date">
		<span>&nbsp;</span>

	</div>
	<div class="lineup-links">

		<a style="width:100% !important;" href="http://www.brunswickmusicfestival.com.au/music-for-the-people/">MORE INFO</a>

	</div>
</div>


<div class="lineup-item mix">

	<!-- START OF TITLE DIV -->
	<div class="lineup-title-support"><!-- END OF TITLE DIV -->


	<a href="http://www.brunswickmusicfestival.com.au/live-at-the-library/" class="fittextTitle lineup-title-a">
	Live at the Library
	</a></div>



	<div class="lineup-image"
	style="background:url('http://www.brunswickmusicfestival.com.au/wp-content/uploads/2016/01/Racy-McNeil-The-Goodlife..jpg');
	background-size:100%;-o-background-size:100%;-ms-background-size:100%;-moz-background-size:100%;-webkit-background-size:100%;
	background-color:#e2a93e;">

	</div>
	<div class="lineup-date">
		<span>&nbsp;</span>

	</div>
	<div class="lineup-links">

		<a style="width:100% !important;" href="http://www.brunswickmusicfestival.com.au/live-at-the-library/">MORE INFO</a>

	</div>
</div>


<div class="lineup-item mix">

	<!-- START OF TITLE DIV -->
	<div class="lineup-title-support"><!-- END OF TITLE DIV -->


	<a href="http://www.brunswickmusicfestival.com.au/counihan-gallery/" class="fittextTitle lineup-title-a">
	Counihan Gallery
	</a></div>

	<div class="lineup-image"
	style="background:url('http://www.brunswickmusicfestival.com.au/wp-content/uploads/2015/12/Kate-Mitchell.FutureFallout__2014-copy.jpg');
	background-size:100%;-o-background-size:100%;-ms-background-size:100%;-moz-background-size:100%;-webkit-background-size:100%;
	background-color:#e2a93e;">

	</div>
	<div class="lineup-date">
		<span>&nbsp;</span>

	</div>
	<div class="lineup-links">

		<a style="width:100% !important;" href="http://www.brunswickmusicfestival.com.au/counihan-gallery/">MORE INFO</a>

	</div>
</div>





</div>
<!-- CONTENT GOES HERE -->


	</div>



</div>

 <?php get_footer(); ?>
