<?php
defined('_JEXEC') or die;
function pagination_list_render($list)
{
$html = '<ul>';
$html .= '<li class="pagination-start">' . $list['start']['data'] . '</li>';
$html .= '<li class="pagination-prev">' . $list['previous']['data'] . '</li>';
foreach ($list['pages'] as $page)
{
$html .= '<li class="pagination-page">' . $page['data'] . '</li>';
}
$html .= '<li class="pagination-next">' . $list['next']['data'] . '</li>';
$html .= '<li class="pagination-end">' . $list['end']['data'] . '</li>';
$html .= '</ul>';
return $html;
}
?>