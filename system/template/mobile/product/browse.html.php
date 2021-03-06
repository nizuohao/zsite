{*php
/**
 * The browse view file of product for mobile template of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Hao Sun <sunhao@cnezsoft.com>
 * @package     product
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/php*}
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header')}
<script>{!echo "place" . md5(time()) . "='" . $config->idListPlaceHolder . '' . $config->idListPlaceHolder . "';"}</script>
{!js::set('pageLayout', $control->block->getLayoutScope('product_browse', $category->id))}
<div class='block-region region-top blocks' data-region='product_browse-top'>{$control->loadModel('block')->printRegion($layouts, 'product_browse', 'top')}</div>
<div class='panel-section'>
  <div class='panel-heading page-header'>
    <div class='title'><strong>{$category->name}</strong></div>
  </div>
  <div class='panel-body'>
    {$count = count($products)}
    {if($count == 0)} {$count = 1} {/if}
    {$recPerRow = min($count, 2)}
    <div class='cards cards-products' data-cols='{$recPerRow}' id='products'>
      <style>{!echo ".col-custom-{{$recPerRow}} {{width: " . (100/$recPerRow) . "%}}"}</style>
      {$index = 0}
      {foreach($products as $product)}
        {$rowIndex = $index % $recPerRow}
        {if($rowIndex === 0)}
          <div class='row'>
        {/if}

        <div class='col col-custom-{$recPerRow}'>
          {$url = helper::createLink('product', 'view', "id=$product->id", "category={{$product->category->alias}}&name=$product->alias")}
          <div class='card' id='product{$product->id}' data-ve='product'>
            <a class='card-img' href='{$url}'>
              {if(empty($product->image))}
                {$imgColor = $product->id * 57 % 360}
                <div class='media-placeholder' style='background-color: hsl({$imgColor}, 60%, 80%); color: hsl({$imgColor}, 80%, 30%);' data-id='{$product->id}'>{$product->name}</div>
              {else}
                {$imgsrc = $control->loadModel('file')->printFileURL($product->image->primary->pathname, $product->image->primary->extension, 'product', 'middleURL')}
                <img class='lazy' alt='{$product->name}' title='{$product->name}' data-src='{$imgsrc}'>
              {/if}
            </a>
            <div class='card-content'>
              <a href='{$url}' style='color:{$product->titleColor}'>{$product->name}</a>
              {if(!$product->unsaleable)}
                {if($product->negotiate)}
                  <div><strong class='text-danger'>{$lang->product->negotiate}</strong></div>'
                {else}
                  {if($product->promotion != 0)}
                    <div><strong class='text-danger'>{!echo $control->config->product->currencySymbol . $product->promotion}</strong>
                      {if($product->price != 0)}
                        &nbsp;&nbsp;<small class='text-muted text-line-through'>{!echo $control->config->product->currencySymbol . $product->price}</small>
                      {/if}
                    </div>
                  {elseif($product->price != 0)}
                    <div><strong class='text-danger'>{!echo $control->config->product->currencySymbol . $product->price}</strong></div>
                  {/if}
                {/if}
              {/if}
            </div>
          </div>
        </div>

        {if($recPerRow === 1 || $rowIndex === ($recPerRow - 1))}
          </div>
        {/if}
        {@$index++}
      {/foreach}
    </div>
  </div>
  <div class='panel-footer'>{$pager->show('justify')}</div>
</div>

<div class='block-region region-bottom blocks' data-region='product_browse-bottom'>{$control->loadModel('block')->printRegion($layouts, 'product_browse', 'bottom')}</div>
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'footer')}
