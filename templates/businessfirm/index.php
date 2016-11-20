<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'framework/functions.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head" />
</head>

<body class="<?php echo $this->params->get('fontfamily'); ?>">
<div id="header-outer" class="clr">
<div id="header-inner">
<div id="logo">
<img class="logo" src="<?php echo $this->baseurl; ?>/<?php echo "$selectlogo"; ?>" />
</div>
<?php if($this->countModules('toolbar')) : ?>
<div id="navigation" class="navbar navbar-inverse">
<span class="navigation">Menu</span>
<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#toolbar">
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
<div id="toolbar" class="navbar-collapse collapse">
<jdoc:include type="modules" name="toolbar" style="none" />
</div>
</div>
<?php endif; ?>
</div>
</div>
<?php if(empty($banner_check)) { ?>
<div id="header-spacer" class="clr">&nbsp;</div>
<?php } ?>
<?php if($this->countModules('banner')) : ?>
<div id="banner-outer" class="clr">
<jdoc:include type="modules" name="banner" style="none" />
</div>
<?php endif; ?>
<?php if($this->countModules('advert1') or $this->countModules('advert2') or $this->countModules('advert3') or $this->countModules('advert4') or $this->countModules('advert5')) : ?>
<div id="advert-black" class="clr">
<div id="advert-inner" class="<?php echo $advert_width; ?>">
<?php if($this->countModules('advert1')) : ?>
<div class="advert first">
<jdoc:include type="modules" name="advert1" style="mhtml" />
</div>
<?php endif; ?>
<?php if($this->countModules('advert2')) : ?>
<div class="advert second">
<jdoc:include type="modules" name="advert2" style="mhtml" />
</div>
<?php endif; ?>
<?php if($this->countModules('advert3')) : ?>
<div class="advert third">
<jdoc:include type="modules" name="advert3" style="mhtml" />
</div>
<?php endif; ?>
<?php if($this->countModules('advert4')) : ?>
<div class="advert forth">
<jdoc:include type="modules" name="advert4" style="mhtml" />
</div>
<?php endif; ?>
<?php if($this->countModules('advert5')) : ?>
<div class="advert fifth">
<jdoc:include type="modules" name="advert5" style="mhtml" />
</div>
<?php endif; ?>
</div>
</div>
<?php endif; ?>
<div id="spacer" class="clr">&nbsp;</div>
<div id="body-outer" class="clr">
<div id="body-float">
<div id="body-inner">
<?php if($this->countModules('left')) : ?>
<div id="left<?php echo $columns; ?>" class="columns">
<jdoc:include type="modules" name="left" style="mhtml" />
</div>
<?php endif; ?>
<div id="body<?php echo $columns; ?>">
<?php if($this->countModules('user1') or $this->countModules('user2') or $this->countModules('user3')) : ?>
<div id="user<?php echo $columns; ?>" class="clr">
<div class="<?php echo $user_width; ?>">
<?php if($this->countModules('user1')) : ?>
<div class="user first">
<jdoc:include type="modules" name="user1" style="mhtml" />
</div>
<?php endif; ?>
<?php if($this->countModules('user2')) : ?>
<div class="user second">
<jdoc:include type="modules" name="user2" style="mhtml" />
</div>
<?php endif; ?>
<?php if($this->countModules('user3')) : ?>
<div class="user third">
<jdoc:include type="modules" name="user3" style="mhtml" />
</div>
<?php endif; ?>
</div>
</div>
<?php endif; ?>
<?php if($this->countModules('user4') or $this->countModules('user5') or $this->countModules('user6')) : ?>
<div id="user<?php echo $columns; ?>" class="clr">
<div class="<?php echo $user2_width; ?>">
<?php if($this->countModules('user4')) : ?>
<div class="user first">
<jdoc:include type="modules" name="user4" style="mhtml" />
</div>
<?php endif; ?>
<?php if($this->countModules('user5')) : ?>
<div class="user second">
<jdoc:include type="modules" name="user5" style="mhtml" />
</div>
<?php endif; ?>
<?php if($this->countModules('user6')) : ?>
<div class="user third">
<jdoc:include type="modules" name="user6" style="mhtml" />
</div>
<?php endif; ?>
</div>
</div>
<?php endif; ?>
<div id="mainbody" class="clr">
<jdoc:include type="message" />
<jdoc:include type="component" />
</div>
<?php if($this->countModules('user7') or $this->countModules('user8') or $this->countModules('user9')) : ?>
<div id="user<?php echo $columns; ?>" class="clr">
<div class="<?php echo $user3_width; ?>">
<?php if($this->countModules('user7')) : ?>
<div class="user first">
<jdoc:include type="modules" name="user7" style="mhtml" />
</div>
<?php endif; ?>
<?php if($this->countModules('user8')) : ?>
<div class="user second">
<jdoc:include type="modules" name="user8" style="mhtml" />
</div>
<?php endif; ?>
<?php if($this->countModules('user9')) : ?>
<div class="user third">
<jdoc:include type="modules" name="user9" style="mhtml" />
</div>
<?php endif; ?>
</div>
</div>
<?php endif; ?>
</div>
<?php if($this->countModules('right')) : ?>
<div id="right<?php echo $columns; ?>" class="columns">
<jdoc:include type="modules" name="right" style="mhtml" />
</div>
<?php endif; ?>
</div>
</div>
</div>
<?php if($this->countModules('bottom1') or $this->countModules('bottom2') or $this->countModules('bottom3') or $this->countModules('bottom4') or $this->countModules('bottom5')) : ?>
<div id="bottom-outer" class="clr">
<div id="bottom-inner" class="<?php echo $bottom_width; ?>">
<?php if($this->countModules('bottom1')) : ?>
<div class="bottom first">
<jdoc:include type="modules" name="bottom1" style="mhtml" />
</div>
<?php endif; ?>
<?php if($this->countModules('bottom2')) : ?>
<div class="bottom second">
<jdoc:include type="modules" name="bottom2" style="mhtml" />
</div>
<?php endif; ?>
<?php if($this->countModules('bottom3')) : ?>
<div class="bottom third">
<jdoc:include type="modules" name="bottom3" style="mhtml" />
</div>
<?php endif; ?>
<?php if($this->countModules('bottom4')) : ?>
<div class="bottom forth">
<jdoc:include type="modules" name="bottom4" style="mhtml" />
</div>
<?php endif; ?>
<?php if($this->countModules('bottom5')) : ?>
<div class="bottom fifth">
<jdoc:include type="modules" name="bottom5" style="mhtml" />
</div>
<?php endif; ?>
</div>
</div>
<?php endif; ?>
<?php if($this->countModules('footer1') or $this->countModules('footer2') or $this->countModules('footer3') or $this->countModules('footer4') or $this->countModules('footer5')) : ?>
<div id="footer-outer" class="clr">
<div id="footer-inner" class="<?php echo $footer_width; ?>">
<?php if($this->countModules('footer1')) : ?>
<div class="footer first">
<jdoc:include type="modules" name="footer1" style="mhtml" />
</div>
<?php endif; ?>
<?php if($this->countModules('footer2')) : ?>
<div class="footer second">
<jdoc:include type="modules" name="footer2" style="mhtml" />
</div>
<?php endif; ?>
<?php if($this->countModules('footer3')) : ?>
<div class="footer third">
<jdoc:include type="modules" name="footer3" style="mhtml" />
</div>
<?php endif; ?>
<?php if($this->countModules('footer4')) : ?>
<div class="footer forth">
<jdoc:include type="modules" name="footer4" style="mhtml" />
</div>
<?php endif; ?>
<?php if($this->countModules('footer5')) : ?>
<div class="footer fifth">
<jdoc:include type="modules" name="footer5" style="mhtml" />
</div>
<?php endif; ?>
</div>
</div>
<?php endif; ?>
<?php include dirname(__FILE__).DIRECTORY_SEPARATOR.'framework/copyframe.php'; ?>
<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template;?>/js/creative.js"></script>
</body>
</html>