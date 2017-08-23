<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
<section class="content-header">
<div class="box-header with-border">
	<h3 class="box-title"><i class="fa fa-user"></i> Tambah Data SKPD</h3>
</div>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-12">
			<div class="box box-solid box-default">
			<?php if($this->session->flashdata('message')){ ?>
			<div class="box-body">
			<div class="alert alert-danger alert-dismissible">
				<button class="close" aria-hidden="true" data-dismiss="alert" type="button">�</button>
			<?php echo $this->session->flashdata('message'); ?>
			</div>
			</div>
			<?php }?>
			<div class="panel-body">
			<?php 
			if($this->uri->segment(3)=="add"){
				echo form_open('setup/position/add');
			}else if($this->uri->segment(3)=="modify"){
				echo form_open('setup/position/modify/'.$this->uri->segment(4));
			}else{
				echo form_open('setup/position/detail');
			}
			?>
				<div class="box-body">
					<div class="col-lg-6">
						<div class="form-group">
							<label >Kd. SKPD.</label>
							<?php echo form_input($kd_skpd)?>
						</div>
						<div class="form-group">
							<label >Kd. Jabatan</label>
							<?php echo form_input($kd_position)?>
						</div>
						<div class="form-group">
							<label >Kd. Parent Jabatan</label>
							<?php echo form_input($parent_position)?>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label >Nama SKPD</label>
							<?php echo form_input($nama_skpd)?>
						</div>
						<div class="form-group">
							<label >Nama Jabatan</label>
							<?php echo form_input($nama)?>
						</div>
						<div class="form-group">
							<label >Nama Parent Jabatan</label>
							<?php echo form_input($parent_name)?>
						</div>
					</div>
					<div class="col-lg-12">
					</div>
					
				</div>
				<div class="box-footer">
					<input class="btn btn-primary" type="submit" name="submit" value="Simpan"/>&nbsp;
					<input class="btn btn-warning" type="reset" name="reset" value="Reset"/>&nbsp;
					<?php echo anchor('setup/position', 
					'<button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Refresh"> Cancel </button>' );?>
				</div>
				<?php echo form_close()?>
				</div>
			</div>
		</div>
	</div>
</section>
</div>