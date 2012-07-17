<?php
/**
* @package   Zoo Component
* @version   1.0.3 2009-03-28 16:17:52
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) 2007 - 2009 YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

?>
<div class="teaser-item">
	<div class="teaser-item-bg">
	<?php if ($item) : ?>
		
		<?php
			$elements = $item->getElements(true);
			$link = JRoute::_($this->link_base.'&view=item&category_id='.$this->category->id.'&item_id='.$item->id);
		?>

		<h1 class="name">
			<a href="<?php echo $link; ?>" title="<?php echo $item->name; ?>"><?php echo $item->name; ?></a>
		</h1>

		<p class="postmeta">
		
			<span class="date">
			<?php echo JText::_('Published on').' '.JHTML::_('date', $item->created, JText::_('DATE_FORMAT_LC1')); ?>
			</span>
		
			<?php if ($related = $item->getRelatedCategories($this->catalog->id, true)) : ?>
			<span class="related">
				<?php echo JText::_('Posted in'); ?>
				<?php
					$categories = array();
					foreach($related as $category) {
						$category_link = JRoute::_($this->link_base.'&view=category&category_id='.$category->id);
						$categories[] = '<a href="'.$category_link.'">'.$category->name.'</a>';
					}
					echo implode(', ', $categories);
				?>
			</span>
			<?php endif; ?>

			<span class="author">
				<?php echo JText::_('Written').' '.JText::_('by').' '.$item->getAuthor(); ?>
			</span>

		</p>

		<?php if (isset($elements['text'])) : ?>
		<div class="text">
			<?php echo $elements['text']->render(ZOO_VIEW_CATEGORY, "intro"); ?>
		</div>
		<?php endif; ?>

		<?php $continue = isset($elements['text']) && $elements['text']->hasValue('readmore') && $elements['text']->hasValue('readmore-tag'); ?>
		<?php if ($continue) : ?>
		<p class="continue">
			<?php if ($continue) : ?>
			<a class="continue" href="<?php echo $link; ?>" title="<?php echo $item->name; ?>"><?php echo JText::_('Continue Reading'); ?> <span class="arrow">&raquo;</span></a>
			<?php endif; ?>
		</p>
		<?php endif; ?>

	<?php endif; ?>
	</div>
</div>
