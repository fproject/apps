<?php
script('pkdrive', 'app');
script('pkdrive', 'file-upload');
script('pkdrive', 'filelist');
script('pkdrive', 'fileactions');
script('pkdrive', 'files');
script('pkdrive', 'fileactionsmenu');
script('pkdrive', 'filesummary');
script('pkdrive', 'fileinfomodel');
script('pkdrive', 'navigation');
script('pkdrive', 'jquery.fileupload');
script('pkdrive', 'jquery.iframe-transport');
script('pkdrive', 'jquery-visibility');
script('pkdrive', 'newfilemenu');
script('pkdrive', 'pkdrive');
style('pkdrive', 'style');
style('files', 'files');
style('files', 'upload');

?>
<div id="app-content">
	<div id="app-content-files" class="viewcontainer has-favorites" style="min-height: initial;">
		<div id="controls">
			<div class="actions creatable hidden">
				<?php /*
			Only show upload button for public page
		*/ ?>
				<?php if(isset($_['dirToken'])):?>
					<div id="upload" class="button upload"
						 title="<?php isset($_['uploadMaxHumanFilesize']) ? p($l->t('Upload (max. %s)', array($_['uploadMaxHumanFilesize']))) : '' ?>">
						<label for="file_upload_start" class="svg icon-upload">
							<span class="hidden-visually"><?php p($l->t('Upload'))?></span>
						</label>
					</div>
				<?php endif; ?>
				<div id="uploadprogresswrapper">
					<div id="uploadprogressbar"></div>
					<button class="stop icon-close" style="display:none">
					<span class="hidden-visually">
						<?php p($l->t('Cancel upload'))?>
					</span>
					</button>
				</div>
			</div>
			<div id="file_action_panel"></div>
			<div class="notCreatable notPublic hidden">
				<?php p($l->t('You don’t have permission to upload or create files here'))?>
			</div>
			<?php /* Note: the template attributes are here only for the public page. These are normally loaded
			 through ajax instead (updateStorageStatistics).
	*/ ?>
			<input type="hidden" name="permissions" value="" id="permissions">
			<input type="hidden" id="max_upload" name="MAX_FILE_SIZE" value="<?php isset($_['uploadMaxFilesize']) ? p($_['uploadMaxFilesize']) : '' ?>">
			<input type="hidden" id="upload_limit" value="<?php isset($_['uploadLimit']) ? p($_['uploadLimit']) : '' ?>">
			<input type="hidden" id="free_space" value="<?php isset($_['freeSpace']) ? p($_['freeSpace']) : '' ?>">
			<?php if(isset($_['dirToken'])):?>
				<input type="hidden" id="publicUploadRequestToken" name="requesttoken" value="<?php p($_['requesttoken']) ?>" />
				<input type="hidden" id="dirToken" name="dirToken" value="<?php p($_['dirToken']) ?>" />
			<?php endif;?>
			<input type="hidden" class="max_human_file_size"
				   value="(max <?php isset($_['uploadMaxHumanFilesize']) ? p($_['uploadMaxHumanFilesize']) : ''; ?>)">
		</div>

		<div id="emptycontent" class="hidden">
			<div class="icon-folder"></div>
			<h2><?php p($l->t('No files in here')); ?></h2>
			<p class="uploadmessage hidden"><?php p($l->t('Upload some content or sync with your devices!')); ?></p>
		</div>

		<div class="nofilterresults emptycontent hidden">
			<div class="icon-search"></div>
			<h2><?php p($l->t('No entries found in this folder')); ?></h2>
			<p></p>
		</div>

		<table id="filestable" data-allow-public-upload="<?php p($_['publicUploadEnabled'])?>" data-preview-x="32" data-preview-y="32">
			<thead>
			<tr>
				<th id='headerName' class="hidden column-name">
					<div id="headerName-container">
						<a class="name sort columntitle" data-sort="name"><span><?php p($l->t( 'Name' )); ?></span><span class="sort-indicator"></span></a>
					</div>
				</th>
				<th id="headerSize" class="hidden column-size">
					<a class="size sort columntitle" data-sort="size"><span><?php p($l->t('Size')); ?></span><span class="sort-indicator"></span></a>
				</th>
				<th id="headerDate" class="hidden column-mtime">
					<a id="modified" class="columntitle" data-sort="mtime"><span><?php p($l->t( 'Modified' )); ?></span><span class="sort-indicator"></span></a>
					<span class="selectedActions"><a href="" class="delete-selected">
							<?php p($l->t('Delete'))?>
							<img class="svg" alt=""
								 src="<?php print_unescaped(OCP\image_path("core", "actions/delete.svg")); ?>" />
						</a></span>
				</th>
			</tr>
			</thead>
			<tbody id="fileList">
			</tbody>
			<tfoot>
			</tfoot>
		</table>
		<input type="hidden" name="dir" id="dir" value="" />
		<div class="hiddenuploadfield">
			<input type="file" id="file_upload_start" class="hiddenuploadfield" name="files[]"
				   data-url="<?php print_unescaped(OCP\Util::linkTo('files', 'ajax/upload.php')); ?>" />
		</div>
		<div id="editor"></div><!-- FIXME Do not use this div in your app! It is deprecated and will be removed in the future! -->
		<div id="uploadsize-message" title="<?php p($l->t('Upload too large'))?>">
			<p>
				<?php p($l->t('The files you are trying to upload exceed the maximum size for file uploads on this server.'));?>
			</p>
		</div>
		<div id="scanning-message">
			<h3>
				<?php p($l->t('Files are being scanned, please wait.'));?> <span id='scan-count'></span>
			</h3>
			<p>
				<?php p($l->t('Currently scanning'));?> <span id='scan-current'></span>
			</p>
		</div>
	</div>
</div>