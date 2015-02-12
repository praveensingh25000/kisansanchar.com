        
		</div>
		<!-- end content -->

		<?php if(!empty($divtonotShowsidebarright) && !in_array($pagename,$divtonotShowsidebarright)){?>
		<!-- start sidebarright -->
	    <?php require_once($DOC_ROOT.'include/sidebarright.php');?>		
		<!-- end sidebarright -->
		<?php } ?>
		
	</div>
	<!-- Pagecontent -->

	<!-- FOOTER -->
	<div id="footer" <?php if(in_array($pagename,$divtonotShowArray)){?>style="width:92%"<?php } ?>>
		<p class="legal">&copy;2014 All Rights Reserved.</p>
	</div>
	<!-- /FOOTER -->
	
	<?php if(!empty($NoloaderPageShowArray) && !in_array($pagename,$NoloaderPageShowArray)){?>
	<!-- windowLoader -->
	<script type="text/javascript">windowLoader();</script>
	<!-- /windowLoader -->
	<?php } ?>

</body>
</html>