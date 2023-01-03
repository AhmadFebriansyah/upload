<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    
                    <?php echo Form::open(['url'=>'login', 'class'=>'form-horizontal']); ?>


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

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <div class="checkbox">
                                <label>
                                    <?php echo Form::checkbox('remember'); ?> Ingat saya
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-sign-in"></i> Login
                            </button>

                            <a class="btn btn-link" href="<?php echo e(url('/password/reset')); ?>">Lupa password</a>
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