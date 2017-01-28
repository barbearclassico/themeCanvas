<?php
/**
 * Simple Machines Forum (SMF)
 *
 * @package SMF
 * @author Simple Machines
 * @copyright 2011 Simple Machines
 * @license http://www.simplemachines.org/about/smf/license.php BSD
 *
 * @version 2.0
 */

/*	This template is, perhaps, the most important template in the theme. It
	contains the main template layer that displays the header and footer of
	the forum, namely with main_above and main_below. It also contains the
	menu sub template, which appropriately displays the menu; the init sub
	template, which is there to set the theme up; (init can be missing.) and
	the linktree sub template, which sorts out the link tree.

	The init sub template should load any data and set any hardcoded options.

	The main_above sub template is what is shown above the main content, and
	should contain anything that should be shown up there.

	The main_below sub template, conversely, is shown after the main content.
	It should probably contain the copyright statement and some other things.

	The linktree sub template should display the link tree, using the data
	in the $context['linktree'] variable.

	The menu sub template should display all the relevant buttons the user
	wants and or needs.

	For more information on the templating system, please see the site at:
	http://www.simplemachines.org/
*/

// Initialize the template... mainly little settings.
function template_init()
{
	global $context, $settings, $options, $txt;

	/* Use images from default theme when using templates from the default theme?
		if this is 'always', images from the default theme will be used.
		if this is 'defaults', images from the default theme will only be used with default templates.
		if this is 'never' or isn't set at all, images from the default theme will not be used. */
	$settings['use_default_images'] = 'never';

	/* What document type definition is being used? (for font size and other issues.)
		'xhtml' for an XHTML 1.0 document type definition.
		'html' for an HTML 4.01 document type definition. */
	$settings['doctype'] = 'xhtml';

	/* The version this template/theme is for.
		This should probably be the version of SMF it was created for. */
	$settings['theme_version'] = '2.0';

	/* Set a setting that tells the theme that it can render the tabs. */
	$settings['use_tabs'] = true;

	/* Use plain buttons - as opposed to text buttons? */
	$settings['use_buttons'] = true;

	/* Show sticky and lock status separate from topic icons? */
	$settings['separate_sticky_lock'] = true;

	/* Does this theme use the strict doctype? */
	$settings['strict_doctype'] = false;

	/* Does this theme use post previews on the message index? */
	$settings['message_index_preview'] = false;

	/* Set the following variable to true if this theme requires the optional theme strings file to be loaded. */
	$settings['require_theme_strings'] = true;
	//theme variants
 	//ss$settings['catch_action'] = array('sub_template' => 'action_wrap');
 	//other thes 


}

// The main sub template above the content.
function template_html_above()
{
	global $context, $settings, $options, $scripturl, $txt, $modSettings;

		// Show right to left and the character set for ease of translating.
		echo '<!DOCTYPE html>
	<html xmlns="http://www.w3.org/1999/xhtml"', $context['right_to_left'] ? ' dir="rtl"' : '', '>
	<head>';
		$check_adm = 0;
		if(isset($_REQUEST['action']) && !empty($_REQUEST['action']) && $_REQUEST['action'] == 'admin')
		$check_adm = 1;
		// The ?fin20 part of this link is just here to make sure browsers don't cache it wrongly.
		echo '
		<link rel="stylesheet" type="text/css" href="', $settings['theme_url'], '/css/index', $context['theme_variant'], '.css?fin20" />
		<link rel="stylesheet" type="text/css" href="', $settings['theme_url'], '/css/fontello.css" />
		<link rel="stylesheet" type="text/css" href="', $settings['theme_url'], '/css/responsive.css" />';
		
		//check admin area
		if(!empty($check_adm))
		echo '
		<link rel="stylesheet" type="text/css" href="', $settings['theme_url'], '/css/jquery.minicolors.css" />
		<link rel="stylesheet" type="text/css" href="', $settings['theme_url'], '/css/admin2.css" />';

		// Some browsers need an extra stylesheet due to bugs/compatibility issues.
		foreach (array('ie7', 'ie6', 'webkit') as $cssfix)
			if ($context['browser']['is_' . $cssfix])
				echo '
		<link rel="stylesheet" type="text/css" href="', $settings['default_theme_url'], '/css/', $cssfix, '.css" />';

		// RTL languages require an additional stylesheet.
		if ($context['right_to_left'])
			echo '
		<link rel="stylesheet" type="text/css" href="', $settings['theme_url'], '/css/rtl.css" />';

		// Here comes the JavaScript bits!
		echo '
		<script type="text/javascript" src="', $settings['default_theme_url'], '/scripts/script.js?fin20"></script>
		<script type="text/javascript" src="', $settings['theme_url'], '/scripts/jquery-3.1.0.min.js"></script>';
		
		//check admin area
		if(!empty($check_adm))
		echo'
		<script type="text/javascript" src="', $settings['theme_url'], '/scripts/jquery.minicolors.min.js"></script>';

		echo'
		<script type="text/javascript" src="', $settings['theme_url'], '/scripts/theme.js?fin20"></script>
		<script type="text/javascript"><!-- // --><![CDATA[
			var smf_theme_url = "', $settings['theme_url'], '";
			var smf_default_theme_url = "', $settings['default_theme_url'], '";
			var smf_images_url = "', $settings['images_url'], '";
			var smf_scripturl = "', $scripturl, '";
			var smf_colorpiker="',!empty($check_adm) ? 'true' :'false','"
			var smf_iso_case_folding = ', $context['server']['iso_case_folding'] ? 'true' : 'false', ';
			var smf_charset = "', $context['character_set'], '";', $context['show_pm_popup'] ? '
			var fPmPopup = function ()
			{
				if (confirm("' . $txt['show_personal_messages'] . '"))
					window.open(smf_prepareScriptUrl(smf_scripturl) + "action=pm");
			}
			addLoadEvent(fPmPopup);' : '', '
			var ajax_notification_text = "', $txt['ajax_in_progress'], '";
			var ajax_notification_cancel_text = "', $txt['modify_cancel'], '";
		// ]]></script>';

		echo '
		<meta http-equiv="Content-Type" content="text/html; charset=', $context['character_set'], '" />
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<meta name="description" content="', $context['page_title_html_safe'], '" />', !empty($context['meta_keywords']) ? '
		<meta name="keywords" content="' . $context['meta_keywords'] . '" />' : '', '
		<title>', $context['page_title_html_safe'], '</title>';

		// Please don't index these Mr Robot.
		if (!empty($context['robot_no_index']))
			echo '
		<meta name="robots" content="noindex" />';

		// Present a canonical url for search engines to prevent duplicate content in their indices.
		if (!empty($context['canonical_url']))
			echo '
		<link rel="canonical" href="', $context['canonical_url'], '" />';

		// Show all the relative links, such as help, search, contents, and the like.
		echo '
		<link rel="help" href="', $scripturl, '?action=help" />
		<link rel="search" href="', $scripturl, '?action=search" />
		<link rel="contents" href="', $scripturl, '" />';

		// If RSS feeds are enabled, advertise the presence of one.
		if (!empty($modSettings['xmlnews_enable']) && (!empty($modSettings['allow_guestAccess']) || $context['user']['is_logged']))
			echo '
		<link rel="alternate" type="application/rss+xml" title="', $context['forum_name_html_safe'], ' - ', $txt['rss'], '" href="', $scripturl, '?type=rss;action=.xml" />';

		// If we're viewing a topic, these should be the previous and next topics, respectively.
		if (!empty($context['current_topic']))
			echo '
		<link rel="prev" href="', $scripturl, '?topic=', $context['current_topic'], '.0;prev_next=prev" />
		<link rel="next" href="', $scripturl, '?topic=', $context['current_topic'], '.0;prev_next=next" />';

		// If we're in a board, or a topic for that matter, the index will be the board's index.
		if (!empty($context['current_board']))
			echo '
		<link rel="index" href="', $scripturl, '?board=', $context['current_board'], '.0" />';

		//dhayzon style theme settings
		echo'
		<style>

		 .dhayzon_menu, #dhayzon_main_menu .open_menu_content{
		 	background:',!empty($settings['dhayzon_menu_bg']) ? $settings['dhayzon_menu_bg']:'inherit;',';
		 }

		 a{
		 	color:',!empty($settings['dhayzon_color_link']) ? $settings['dhayzon_color_link']:'inherit;',';
		 }
		 #panel_1,#footer_section .frame,.dhazon_svg_icon{
		 	background-color:',!empty($settings['dhayzon_header_bg']) ? $settings['dhayzon_header_bg'] :'inherit;',';
		 }
		 #footer_section .decor,.order_by_dhayzon{
		 	fill:',!empty($settings['dhayzon_header_bg']) ? $settings['dhayzon_header_bg'] :'inherit;',';
		 }';

		if(!empty($settings['dhayzon_news_bg'])) 
		 echo'.dhayzon_news{background-color:'.$settings['dhayzon_news_bg'].';}';
			 
		if(!empty($settings['dhayzon_forumwidht']))
			echo'
				#content_section,.dhayzon_log_in{width:'.$settings['dhayzon_forumwidht'].';	}';
	 
		echo'
		</style>
		';

		// Output any remaining HTML headers. (from mods, maybe?)
		echo $context['html_headers'];

		echo '
	</head>
	<body>';
}

function template_body_above()
{
	global $context, $settings, $options, $scripturl, $txt, $modSettings;


 
	// Show the menu here, according to the menu sub template..	
	echo' 
	<div class="dhayzon_menu">
	',template_menu(),'
	</div>
	<div id="wrapper">';

	if(!$context['user']['is_guest']){
		echo'
	
	<div id="user_options"><a href="#usermenu" data-open="oBreadcrumb" class="clicked"> 
	', !empty($context['user']['avatar']['image']) ? $context['user']['avatar']['image']: '<img src="'.$settings['theme_url'].'/images/theme/default.png" alt="" class="avatar emtyAv"  data-avatar="'.$context['user']['name'].'"/>', '</a>';

		echo'
		<ul class="opciones_usuario open_options reset" style="display:none">
 							<li><a href="', $scripturl, '?action=profile"><i class="icon-user-male"></i> ',$txt['my_theme_profile'], '</a></li>
							<li><a href="',$scripturl,'?action=profile;area=forumprofile#personal_picture"><i class="icon-camera"></i> ', $txt['my_theme_avatar'] , '</a></li>
							<li><a href="', $scripturl, '?action=profile;area=theme"><i class="icon-art-gallery"></i> ', $txt['my_theme_design'], '</a></li>
							<li><a href="', $scripturl, '?action=profile;area=forumprofile"><i class="icon-cog"></i> ',$txt['my_theme_basic'] , '</a></li>
							<li><a href="', $scripturl, '?action=profile;area=account"><i class="icon-lock-filled"></i> ',$txt['my_theme_secure'], '</a></li>
							<li><a href="', $scripturl, '?action=profile;area=notification"><i class="icon-attention"></i> ', $txt['my_theme_notification'], '</a></li>
		</ul></div>';
	}else{
		echo'<div class="guest_reg"><a href="',$scripturl,'?action=register" class="btn-success">',$txt['register'],'</a></div>';
	}

	echo'<a href="#open" data-open="openh" id="sSidenav" class="aHamburger-icon"><span class="hamburgerIcon"></span></a>';
		// Show the navigation tree.

	theme_linktree();
	//
	echo'
	<div  id="panel_1" ',!empty($settings['dhayzon_img_bg']) ? 'style="background-image: url('.$settings['dhayzon_img_bg'].');"':'','>
	  <div class="panel_wrapper">

	 <h1 class="forumtitle">
						<a href="', $scripturl, '">', empty($settings['header_title_pague']) ? $context['forum_name'] : $settings['header_title_pague'], '</a>
		 </h1> 
		 ', !empty($settings['site_slogan']) ? '<p class="dhayzon_site_slogan">' . $settings['site_slogan'] . '</p>' : '', ' 

	 </div>
<div class="footer-svg"><svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg">
<path d="M0 100 L100 0 L100 100" stroke-width="0"></path>
</svg></div>
	 </div>';
	echo'<div id="dhayzon_wrapper">
			 
			 
 					';

					// Otherwise they're a guest - this time ask them to either register or login - lazy bums...
					if(!empty($context['show_login_bar']) && !$context['user']['is_logged'])
					{
						echo '<div class="dhayzon_log_in"><div class="user dhayzon"><ul class="floatleft"><li><div class="info">', sprintf($txt['welcome_guest'], $txt['guest_title']), '</div></li><li><div class="info">', $txt['quick_login_dec'], '</div></li></ul>
							<div class="floatright dhayzon_login_form">	<script type="text/javascript" src="', $settings['default_theme_url'], '/scripts/sha1.js"></script>
								<form id="guest_form" action="', $scripturl, '?action=login2" method="post" accept-charset="', $context['character_set'], '" ', empty($context['disable_login_hashing']) ? ' onsubmit="hashLoginPassword(this, \'' . $context['session_id'] . '\');"' : '', '>
								<ul>
								
									<li><input type="text" name="user" size="10" class="input_text" /></li>
									<li><input type="password" name="passwrd" size="10" class="input_password" /></li>
									<li><select name="cookielength">
										<option value="60">', $txt['one_hour'], '</option>
										<option value="1440">', $txt['one_day'], '</option>
										<option value="10080">', $txt['one_week'], '</option>
										<option value="43200">', $txt['one_month'], '</option>
										<option value="-1" selected="selected">', $txt['forever'], '</option>
									</select></li>
									<li><input type="submit" value="', $txt['login'], '" class="button_submit" /></li>
									';

						if (!empty($modSettings['enableOpenID']))
							echo '
									<li><input type="text" name="openid_identifier" id="openid_url" size="25" class="input_text openid_login" /></li>';

						echo '<li><input type="hidden" name="hash_passwrd" value="" /></li>
								</ul>
									</form>
									</div>
								</div>
							</div>';


					}
 

	
	// The main content should go here.
	echo '
	<div id="content_section"><div class="frame">
		<div id="main_content_section">'; 

				// Show a random news item? (or you could pick one from news_lines...)
				if (!empty($settings['enable_news']))
					echo '<div class="dhayzon_news panel_wrapper">
							<h2>', $txt['news'], ': </h2>
							<span>', $context['random_news_line'], '</span></div>';
	// Custom banners and shoutboxes should be placed here, before the linktree.

}

function template_body_below()
{
	global $context, $settings, $options, $scripturl, $txt, $modSettings;

	echo '
		</div>
	</div></div>';

	// Show the "Powered by" and "Valid" logos, as well as the copyright. Remember, the copyright must be somewhere!
	if(!empty($settings['dhayzon_ads_indexFooter']))
		echo'<div class="content centertext">',$settings['dhayzon_ads_indexFooter'],' </div>';
	echo '
	</div>
	<div id="footer_section">
		<div class="footer-svg"><svg class="decor" height="100%" preserveAspectRatio="none" version="1.1" viewBox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg">
	<path d="M0 100 L100 0 L100 100" stroke-width="0"></path>
	</svg></div><div class="frame">
		<ul class="reset floatleft">
			<li class="copyright">', theme_copyright(), '</li>
			<li><a id="button_xhtml" href="http://validator.w3.org/check?uri=referer" target="_blank" class="new_win" title="', $txt['valid_xhtml'], '"><span>', $txt['xhtml'], '</span></a></li>
			', !empty($modSettings['xmlnews_enable']) && (!empty($modSettings['allow_guestAccess']) || $context['user']['is_logged']) ? '<li><a id="button_rss" href="' . $scripturl . '?action=.xml;type=rss" class="new_win"><span>' . $txt['rss'] . '</span></a></li>' : '', '
			<li class="last"><a id="button_wap2" href="', $scripturl , '?wap2" class="new_win"><span>', $txt['wap2'], '</span></a></li>
		</ul>
		<ul class="reset floatright">
			<li><a href="http://dhayzon.com" target="_blank">Design by Dhayzon</a></li>
		</ul>';

	// Show the load time?
	if ($context['show_load_time'])
		echo '
		<p>', $txt['page_created'], $context['load_time'], $txt['seconds_with'], $context['load_queries'], $txt['queries'], '</p>';

	echo '
	</div></div> 

</div>';
}

function template_html_below()
{
	global $context, $settings, $options, $scripturl, $txt, $modSettings;

	echo '
	<script type="text/javascript" src="', $settings['theme_url'], '/scripts/sDtheme.js"></script>
	</body></html>';
}

// Show a linktree. This is that thing that shows "My Community | General Category | General Discussion"..
function theme_linktree($force_show = false)
{
	global $context, $settings, $options, $shown_linktree;

	// If linktree is empty, just return - also allow an override.
	if (empty($context['linktree']) || (!empty($context['dont_default_linktree']) && !$force_show))
		return;

	echo '
	<div class="navigate_section">	
	<a href="#oBreadcrumb" data-open="oBreadcrumb" id="oBreadcrumb" class="clicked"> <i class="icon-location"></i></a>
		<ul style="display:none">';

	// Each tree item has a URL and name. Some may have extra_before and extra_after.
	foreach ($context['linktree'] as $link_num => $tree)
	{
		echo '
			<li', ($link_num == count($context['linktree']) - 1) ? ' class="last"' : '', '>';

		// Show something before the link?
		if (isset($tree['extra_before']))
			echo $tree['extra_before'];

		// Show the link, including a URL if it should have one.
		echo $settings['linktree_link'] && isset($tree['url']) ? '
				<a href="' . $tree['url'] . '"><span>'. $tree['name'] . '</span></a>' : '<span>'. $tree['name'] . '</span>';

		// Show something after the link...?
		if (isset($tree['extra_after']))
			echo $tree['extra_after'];

		// Don't show a separator for the last one.
		//if ($link_num != count($context['linktree']) - 1)
		//	echo ' &#187;';

		echo '
			</li>';
	}
	echo '
		</ul>
	</div>';

	$shown_linktree = true;
}

// Show the menu up top. Something like [home] [help] [profile] [logout]...
function template_menu()
{
	global $context, $settings, $options, $scripturl, $txt;

	echo '
		<div id="dhayzon_main_menu">
			<ul id="menu_nav">';

	foreach ($context['menu_buttons'] as $act => $button)
	{
		echo '
				<li id="button_', $act, '">
					<a class="', $button['active_button'] ? 'active ' : '', 'dhayzno_menu_firstlevel" href="', $button['href'], '"', isset($button['target']) ? ' target="' . $button['target'] . '"' : '', '>
						<span class="', isset($button['is_last']) ? 'last ' : '', 'dhayzno_menu_firstlevel">', $button['title'], '
						</span></a>',!empty($button['sub_buttons'])? '<span class="floatright dhayznon_toggle_menu toggle"></span>':'','
					';
		if (!empty($button['sub_buttons']))
		{
			echo '
					<ul style="display:none" class="two_level_menu ">';

			foreach ($button['sub_buttons'] as $childbutton)
			{
				echo '
						<li>
							<a href="', $childbutton['href'], '"', isset($childbutton['target']) ? ' target="' . $childbutton['target'] . '"' : '', '>
								<span', isset($childbutton['is_last']) ? ' class="last"' : '', '>', $childbutton['title'], !empty($childbutton['sub_buttons']) ? '...' : '', '</span>
							</a>';
				// 3rd level menus :)
				if (!empty($childbutton['sub_buttons']))
				{
					echo '
							<ul style="display:none">';

					foreach ($childbutton['sub_buttons'] as $grandchildbutton)
						echo '
								<li>
									<a href="', $grandchildbutton['href'], '"', isset($grandchildbutton['target']) ? ' target="' . $grandchildbutton['target'] . '"' : '', '>
										<span', isset($grandchildbutton['is_last']) ? ' class="last"' : '', '>', $grandchildbutton['title'], '</span>
									</a>
								</li>';

					echo '
							</ul>';
				}

				echo '
						</li>';
			}
				echo '
					</ul>';
		}

		 if ($act == 'home')
		  	echo'<a href="#open" data-open="openh" class="aHamburger-icon openh floatright"><span class="hamburgerIcon"></span></a>'; 
		echo '
				</li>';
	}

	echo '
			</ul>
		</div>';
}

// Generate a strip of buttons.
function template_button_strip($button_strip, $direction = 'top', $strip_options = array())
{
	global $settings, $context, $txt, $scripturl;

	if (!is_array($strip_options))
		$strip_options = array();

	// List the buttons in reverse order for RTL languages.
	if ($context['right_to_left'])
		$button_strip = array_reverse($button_strip, true);

	// Create the buttons...
	$buttons = array();
	foreach ($button_strip as $key => $value)
	{
		if (!isset($value['test']) || !empty($context[$value['test']]))
			$buttons[] = '
				<li><a' . (isset($value['id']) ? ' id="button_strip_' . $value['id'] . '"' : '') . ' class="button_strip_' . $key . (isset($value['active']) ? ' active' : '') . '" href="' . $value['url'] . '"' . (isset($value['custom']) ? ' ' . $value['custom'] : '') . '><span>' . $txt[$value['text']] . '</span></a></li>';
	}

	// No buttons? No button strip either.
	if (empty($buttons))
		return;

	// Make the last one, as easy as possible.
	$buttons[count($buttons) - 1] = str_replace('<span>', '<span class="last">', $buttons[count($buttons) - 1]);

	echo '
		<div class="buttonlist', !empty($direction) ? ' float' . $direction : '', '"', (empty($buttons) ? ' style="display: none;"' : ''), (!empty($strip_options['id']) ? ' id="' . $strip_options['id'] . '"': ''), '>

			<a  href="#dhayzonTogleOptions" data-toggle="dhayzonTogleOptions" class="clicked"><span class="hdotted"><span></span></span></a>
			<ul style="display:none">',
				implode('', $buttons), '
			</ul>
		</div>';
}

?>