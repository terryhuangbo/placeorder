<style>
    .avatar_content{
        height: 120px;
        width: 140px;
        display: block;
        margin-bottom: 20px;
        margin-right: 160px;
    }
    .avatar_img{
        height: 100px;
        width: 120px;
        margin: 10px 40px;
    }
    .pic-content{
        margin-bottom: 15px;
    }


</style>
<div id="content" style="display: block" >
    <form id="form" class="form-horizontal">
        <div class="row">

            <div class="control-group span8">
                <label class="control-label">微信昵称：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $user['nick'] ?></span>
                </div>
            </div>
            <div class="control-group span8">
                <label class="control-label">真实姓名：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $user['name'] ?></span>
                </div>
            </div>
        </div>
        <div class="row pic-content">

            <div class="control-group span10 avatar_content" >
                <label class="control-label">微信头像：</label>
                <div class="controls">
                    <img class="avatar_img" src="<?php echo $user['avatar'] ?>">
                </div>
            </div>
            <div  class="control-group span10 avatar_content" >
                <label class="control-label " id="upload_img">
                    名片
                </label>
                <div  class="controls " >
                    <img id="name_card_img" class="avatar_img" onclick="viewNameCard(this)" src="<?php echo $user['name_card'] ?>">
                    <input id="name_card_input" type="hidden" value="<?php echo $user['name_card'] ?>">
                </div>
            </div>
        </div>
        <div class="row">

            <div class="control-group span8">
                <label class="control-label">手机号码：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $user['mobile']?></span>
                </div>
            </div>
            <div class="control-group span8">
                <label class="control-label">邮箱：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $user['email'] ?></span>
                </div>
            </div>
            <div class="control-group span8">
                <label class="control-label">积分：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $user['points'] ?></span>
                </div>
            </div>
            <div class="control-group span8">
                <label class="control-label">微信公众号：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $user['wechat_openid'] ?></span>
                </div>
            </div>
            <div class="control-group span8">
                <label class="control-label">用户类型：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $user['user_type'] ?></span>
                </div>
            </div>
            <div class="control-group span8">
                <label class="control-label">用户状态：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $user['user_status'] ?></span>
                </div>
            </div>

            <div class="control-group span8">
                <label class="control-label">申请时间：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $user['create_at'] ?></span>
                </div>
            </div>
            <div class="control-group span8">
                <label class="control-label">更新时间：</label>
                <div class="controls">
                    <span  class="control-text" ><?php echo $user['update_at'] ?></span>
                </div>
            </div>
        </div>

    </form>
</div>