<?php


# TOTAL MEMBERS
function get_total_members() {
  global $conn, $start, $end;
  $sql = "SELECT COUNT(a.id)
          FROM account AS a
          WHERE a.joinedon >= '{$start}'
          AND a.joinedon < '{$end}'
          AND a.isonboarded = TRUE
          AND a.emailverified = TRUE";
  $rst = pg_query($conn, $sql);
  return pg_fetch_result($rst, 0, 0);
}


# TOTAL ARTISTS
function get_total_artists() {
  global $conn, $start, $end;
  $sql = "SELECT COUNT(a.id)
          FROM account AS a, accounttype AS at
          WHERE a.joinedon >= '{$start}'
          AND a.joinedon < '{$end}'
          AND a.isonboarded = TRUE
          AND a.emailverified = TRUE
          AND a.accounttypeid = at.id
          AND at.roleid = 3";
  $rst = pg_query($conn, $sql);
  return pg_fetch_result($rst, 0, 0);
}


# ARTISTS RATIO
function get_artists_ratio() {
  global $conn, $start, $end;
  $ratio = get_total_artists() / get_total_members();
  return round((float)$ratio * 100 ) . '%';
}


# TOTAL TALENT SEEKERS
function get_total_talent_seekers() {
  global $conn, $start, $end;
  $sql = "SELECT COUNT(a.id)
          FROM account AS a, accounttype AS at
          WHERE a.joinedon >= '{$start}'
          AND a.joinedon < '{$end}'
          AND a.isonboarded = TRUE
          AND a.emailverified = TRUE
          AND a.accounttypeid = at.id
          AND at.roleid = 4";
  $rst = pg_query($conn, $sql);
  return pg_fetch_result($rst, 0, 0);
}


# TALENT SEEKERS RATIO
function get_talent_seekers_ratio() {
  global $conn, $start, $end;
  $ratio = get_total_talent_seekers() / get_total_members();
  return round((float)$ratio * 100 ) . '%';
}

# STARTED ONBOARDING
function get_started_onboarding() {
  global $conn, $start, $end;
  $sql = "SELECT COUNT(a.id)
          FROM account AS a
          WHERE a.joinedon >= '{$start}'
          AND a.joinedon < '{$end}'";
  $rst = pg_query($conn, $sql);
  return pg_fetch_result($rst, 0, 0);
}


# FINISHED ONBOARDING
function get_finished_onboarding() {
  global $conn, $start, $end;
  $sql = "SELECT COUNT(a.id)
          FROM account AS a
          WHERE a.joinedon >= '{$start}'
          AND a.joinedon < '{$end}'
          AND a.isonboarded = TRUE
          AND a.emailverified = TRUE";
  $rst = pg_query($conn, $sql);
  return pg_fetch_result($rst, 0, 0);
}


# ONBOARDING COMPLETION RATIO
function get_onboarding_completion_ratio() {
  global $conn, $start, $end;
  $ratio = get_finished_onboarding() / get_started_onboarding();
  return round((float)$ratio * 100 ) . '%';
}


# TOTAL POSTS
function get_total_posts() {
  global $conn, $start, $end;
  return get_total_gig_posts() + get_total_seeking_posts() + get_total_avail_posts();
}


# TOTAL GIG POSTS
function get_total_gig_posts() {
  global $conn, $start, $end;
  $sql = "SELECT COUNT(g.id)
          FROM gig AS g
          WHERE g.createdon >= '{$start}'
          AND g.createdon < '{$end}'";
  $rst = pg_query($conn, $sql);
  return pg_fetch_result($rst, 0, 0);
}


# GIG POSTS RATIO
function get_gig_posts_ratio() {
  global $conn, $start, $end;
  $ratio = get_total_gig_posts() / get_total_posts();
  return round((float)$ratio * 100 ) . '%';
}


# TOTAL SEEKING POSTS
function get_total_seeking_posts() {
  global $conn, $start, $end;
  $sql = "SELECT COUNT(s.id)
          FROM seeking AS s
          WHERE s.createdon >= '{$start}'
          AND s.createdon < '{$end}'";
  $rst = pg_query($conn, $sql);
  return pg_fetch_result($rst, 0, 0);
}


# SEEKING POSTS RATIO
function get_seeking_posts_ratio() {
  global $conn, $start, $end;
  $ratio = get_total_seeking_posts() / get_total_posts();
  return round((float)$ratio * 100 ) . '%';
}


# TOTAL AVAIL POSTS
function get_total_avail_posts() {
  global $conn, $start, $end;
  $sql = "SELECT COUNT(a.id)
          FROM avail AS a
          WHERE a.createdon >= '{$start}'
          AND a.createdon < '{$end}'";
  $rst = pg_query($conn, $sql);
  return pg_fetch_result($rst, 0, 0);
}


# AVAIL POSTS RATIO
function get_avail_posts_ratio() {
  global $conn, $start, $end;
  $ratio = get_total_avail_posts() / get_total_posts();
  return round((float)$ratio * 100 ) . '%';
}


# GIG POST APPLICATIONS
function get_gig_post_applications() {
  global $conn, $start, $end;
  $sql = "SELECT COUNT(ga.id)
          FROM gigapplication AS ga
          WHERE ga.createdon >= '{$start}'
          AND ga.createdon < '{$end}'";
  $rst = pg_query($conn, $sql);
  return pg_fetch_result($rst, 0, 0);
}


# GIG POST BOOKINGS
function get_gig_post_bookings() {
  global $conn, $start, $end;
  $sql = "SELECT COUNT(ga.id)
          FROM gigapplication AS ga
          WHERE ga.createdon >= '{$start}'
          AND ga.createdon < '{$end}'
          AND ga.status = 'accepted'";
  $rst = pg_query($conn, $sql);
  return pg_fetch_result($rst, 0, 0);
}


# GIG POST BOOKING RATIO 
function get_gig_post_booking_ratio() {
  global $conn, $start, $end;
  $ratio = get_gig_post_bookings() / get_gig_post_applications();
  return round((float)$ratio * 100 ) . '%';
}



// Setup database connection
$conn = pg_connect("host=encore.cmgikwlh6ez1.us-west-1.rds.amazonaws.com port=5432 dbname=gigmor_encore user=encore password=c0r#n#2017") or die("error: ".pg_last_error());

// Setup basic date params
$start = date('Y-m-d 00:00:00', strtotime('-1 month'));
$end = date('Y-m-d 00:00:00');

?>

Encore Monthly Activity Report - <?= strtoupper(date('F Y', strtotime($start))) ?>
<br>
MEMBERS
<br>
  Total Members, <?= get_total_members() ?>
<br>
  Artists, <?= get_total_artists() ?>
<br>
  Talent Seekers, <?= get_total_talent_seekers() ?>
<br>
  Started Onboarding, <?= get_started_onboarding() ?>
<br>
  Finished Onboarding, <?= get_finished_onboarding() ?>
<br>
POSTS
<br>
  Total Posts, <?= get_total_posts() ?>
<br>
  Gig Posts, <?= get_total_gig_posts() ?>
<br>
  Seeking Posts, <?= get_total_seeking_posts() ?>
<br>
  Avail Posts, <?= get_total_avail_posts() ?>
<br>
  Gig Post Applications, <?= get_gig_post_applications() ?>
<br>
  Gig Post Bookings, <?= get_gig_post_bookings() ?>

