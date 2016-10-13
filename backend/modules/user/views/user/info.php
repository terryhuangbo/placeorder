<div id="content" style="display: block" >
    <form id="form" class="form-horizontal">
        <div class="row">

            <div class="control-group ">
                <label class="control-label">用户账号：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $user['username'] ?></span>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">QQ：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $user['qq'] ?></span>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">账号余额：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $user['points'] ?></span>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">注册时间：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $user['reg_time']?></span>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">最近登录：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $user['login_time'] ?></span>
                </div>
            </div>
        </div>
    </form>
</div>