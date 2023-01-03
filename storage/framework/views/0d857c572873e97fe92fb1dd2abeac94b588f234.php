<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <?php echo Form::open(['url'=>'/register', 'class'=>'form-horizontal']); ?>


                    <div class="form-group<?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
                        <?php echo Form::label('name', 'Nama', ['class'=>'col-md-4 control-label']); ?>

                        <div class="col-md-6">
                            <?php echo Form::text('name', null, ['class'=>'form-control']); ?>

                            <?php echo $errors->first('name', '<p class="help-block">:message</p>'); ?>

                        </div>
                    </div>

                    <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                        <?php echo Form::label('email', 'Alamat Email', ['class'=>'col-md-4 control-label']); ?>

                        <div class="col-md-6">
                            <?php echo Form::email('email', null, ['class'=>'form-control']); ?>

                            <?php echo $errors->first('email', '<p class="help-block">:message</p>'); ?>

                        </div>
                    </div>

                    <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                        <?php echo Form::label('password', 'Password', ['class'=>'col-md-4 control-label']); ?>

                        <div class="col-md-6">
                            <?php echo Form::password('password', ['class'=>'form-control']); ?>

                            <?php echo $errors->first('password', '<p class="help-block">:message</p>'); ?>

                        </div>
                    </div>

                    <div class="form-group<?php echo e($errors->has('password_confirmation') ? ' has-error' : ''); ?>">
                        <?php echo Form::label('password_confirmation', 'Konfirmasi Password', ['class'=>'col-md-4 control-label']); ?>

                        <div class="col-md-6">
                            <?php echo Form::password('password_confirmation', ['class'=>'form-control']); ?>

                            <?php echo $errors->first('password_confirmation', '<p class="help-block">:message</p>'); ?>

                        </div>
                    </div>

                    <div class="form-group<?php echo e($errors->has('g-recaptcha-response') ? ' has-error' : ''); ?>">
                        <div class="col-md-offset-4 col-md-6">
                            <?php echo app('captcha')->display(); ?>

                            <?php echo $errors->first('g-recaptcha-response', '<p class="help-block">:message</p>'); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-user"></i> Daftar
                            </button>
                        </div>
                    </div>
                    <?php echo Form::close(); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>