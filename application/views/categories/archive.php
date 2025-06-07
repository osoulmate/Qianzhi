	<div class="container">
        <div class="row" style="margin-bottom: 30%;">
            <div class="col-sm-12 col-md-12 col-lg-12">
            	<h2 style="margin:20px 10px;padding:10px;">月度归档</h2>
            	<ul style="margin:20px 50px;padding:10px;list-style-type: disc;">
				<?php if(!empty($monthCount)):?>
				<?php foreach ($monthCount as $month):?>
					<?php foreach ($month as $newmonth):?>
					<?php $date = str_replace('-','/',$newmonth['date']).'/';?>
					<?php $viewdate = str_replace('-','/',$newmonth['date']);?>
				    <li><?php echo $html->link($viewdate,$date);?>
				    	<span class="badge badge-info"><?php echo $newmonth['count']?></span>
					</li>
				    <?php endforeach?>
				<?php endforeach?>
				<?php endif?>
            	</ul>
            </div>
        </div>
    </div>

