<?php if(Yii::app()->user->getIsGuest()):?>
<span>
	要评论先
	<a href="javascript:;" id="need_login"><?php echo Yii::t('common','Login');?></a>或者
	<a href="<?php echo $this->createUrl('user/register');?>"><?php echo Yii::t('common','Register');?></a>
</span>
<?php else:?>
<form class="contact_form" method="post" >
	<table>
		<CAPTION>我要评论:</CAPTION>
		<tr><th><?php echo Yii::t('common','User');?>：</th><td><input type="hidden" value="<?php echo Yii::app()->user->name;?>"  name="nickname"/><?php echo Yii::app()->user->name;?></td></tr>							
		<tr>
			<th><?php echo Yii::t('common','Content');?>：</th>
			<td>
				<textarea id="Comment" name="content"></textarea>
				<?php $this->widget('application.widget.kindeditor.KindEditor',array(
				  'target'=>array(
				  	'#Comment'=>array(
						 'themeType'=>'simple',
				  		 'width'=>'100%',	
						 'height'=>'200',						 
						)				  		
					)						
				)
				);?>				
			</td>			
		</tr>
		<tr class="sub_tr">
			<td><input type="hidden" name="post_id" value="<?php echo $post->id;?>" /></td>
			<td>
				<a href="javascript:;" id="submit" class="submit"><?php echo Yii::t('common','Submit');?></a>				
			</td>
		</tr>
	</table>				
</form>
<?php endif;?>
<script type="text/javascript">
	$(function(){
		$("#need_login").click(function(){
			$.Zebra_Dialog('',
				{
				    source: {'iframe': {
				        'src':  '<?php echo $this->createUrl('user/ajaxlogin',
				        		array('ret_url'=>$this->_request->getUrl()));?>',
				        'height': 310
				    }},
				    width: 462,
				    title: "<?php echo Yii::t('common','Login');?>",
				    type:'', 
				}
			);
		});

		$("#submit").click(function(){
			var post_id = $("input[name='post_id']").val();
			var user_id = "<?php echo Yii::app()->user->id?>";
			var nickname = $("input[name='nickname']").val();			
			var content = $("#Comment").val();			
			$.post("<?php echo $this->createUrl('post/postComment');?>",{"post_id":post_id,"nickname":nickname, "user_id":user_id, "content":content},function(data){
				if(data.state =='error'){
					$.Zebra_Dialog(data.message);
				}else{
					$.Zebra_Dialog(data.message);
					window.location.reload();
				}
			},'json');
		});
	});
</script>
<script type="text/javascript" src="<?php echo $this->_baseUrl?>/static/public/js/zebra_dialog/zebra_dialog.js"></script>
<link rel="stylesheet" href="<?php echo $this->_baseUrl?>/static/public/js/zebra_dialog/css/zebra_dialog.css" type="text/css">