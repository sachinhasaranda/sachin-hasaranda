<?php
defined('_JEXEC') or die;
$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$sitetitle = $app->getCfg('sitename');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->error->getCode(); ?> - <?php echo htmlspecialchars($this->error->getMessage(), ENT_QUOTES, 'UTF-8'); ?></title>
<style type="text/css">
body { margin: 0px; background: #f0f0f0; font-size: 16px; }
#box-frame { border: 1px solid #c0c0c0; padding: 20px; margin: 0 auto; background: #f8f8f8; text-align: center; }
h3 { margin: -20px -20px 10px -20px; padding: 10px 20px; background: #f0f0f0; border-bottom: 1px solid #c0c0c0; }
h2, h4, h5 { margin: 0px; padding: 0px; }
h1 { font-size: 26px; }
h2 { font-size: 24px; }
h3 { font-size: 22px; }
h4 { font-size: 20px; }
h5 { font-size: 18px; }
.back_button { border: 1px solid #c0c0c0; padding: 5px 10px; font-size: 20px; color: #000000; text-decoration: none; border-radius: 5px; background: #f0f0f0; font-weight: bold; }
li { margin-bottom: 5px; }
@media screen and (min-width:768px){
#box-frame { width: 700px; }
}
</style>
</head>

<body>
<div style="padding:20px 15px;">
<div id="box-frame">
<h3><?php echo "$sitetitle"; ?></h3>
<h2>The requested page cannot be found</h2>
<h4 style="margin-bottom:20px;">An error has occurred while processing your request</h4>
<h5 style="margin-bottom:10px;"><?php echo JText::_('JERROR_LAYOUT_NOT_ABLE_TO_VISIT'); ?></h5>
<li><?php echo JText::_('JERROR_LAYOUT_AN_OUT_OF_DATE_BOOKMARK_FAVOURITE'); ?></li>
<li><?php echo JText::_('JERROR_LAYOUT_SEARCH_ENGINE_OUT_OF_DATE_LISTING'); ?></li>
<li><?php echo JText::_('JERROR_LAYOUT_MIS_TYPED_ADDRESS'); ?></li>
<li><?php echo JText::_('JERROR_LAYOUT_YOU_HAVE_NO_ACCESS_TO_THIS_PAGE'); ?></li>
<li><?php echo JText::_('JERROR_LAYOUT_REQUESTED_RESOURCE_WAS_NOT_FOUND'); ?></li>
<li><?php echo JText::_('JERROR_LAYOUT_ERROR_HAS_OCCURRED_WHILE_PROCESSING_YOUR_REQUEST'); ?></li>
<h4 style="margin:20px 0px 15px 0px;"><?php echo JText::_('JERROR_LAYOUT_PLEASE_TRY_ONE_OF_THE_FOLLOWING_PAGES'); ?></h4>
<a class="back_button" href="<?php echo $this->baseurl; ?>/" title="<?php echo JText::_('JERROR_LAYOUT_GO_TO_THE_HOME_PAGE'); ?>"><?php echo JText::_('JERROR_LAYOUT_HOME_PAGE'); ?></a>
<span style="margin-top:20px; display:block;"><?php echo JText::_('JERROR_LAYOUT_PLEASE_CONTACT_THE_SYSTEM_ADMINISTRATOR'); ?></span>
<h4 style="margin-top:10px;"><?php echo $this->error->getCode(); ?> <?php echo htmlspecialchars($this->error->getMessage(), ENT_QUOTES, 'UTF-8'); ?></h4>
</div>
</div>
</body>
</html>
