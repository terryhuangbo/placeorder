<!DOCTYPE html>
<html>
    <head>
        <title>目录树结构</title>
        <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/libs/bootstrap/3.2.0/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="http://static.vsochina.com/libs/bootstrap-treeview/css/bootstrap-treeview.min.css">
    </head>
    <body>
        <div class="container">
            <h1>基于bootstrap的目录树结构</h1>
            <br/>
            <div class="row">
                <div class="col-sm-12">
                    <label for="treeview"></label>
                    <div id="treeview"></div>
                </div>
            </div>
        </div>

        <script type="text/javascript" src="http://static.vsochina.com/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="http://static.vsochina.com/libs/bootstrap-treeview/js/bootstrap-treeview.min.js"></script>

        <script type="text/javascript">
            $(function() {
                var options = {
                    bootstrap2: false, 
                    showTags: false,
                    levels: 5,
                    data: [{
                        "id":1,
                        "text":"第一层",
                        "nodes":[{
                            "id":2,
                            "text":"第二层",
                            "nodes":[{
                                "id":0,
                                "text":"第三层",
                                "nodes":[{
                                    "id":0,
                                    "text":"第四层",
                                    "nodes":[{
                                        "id":0,
                                        "text":"第五层"
                                    }]
                                }]
                            }]
                        }]
                    }]
                };
                $('#treeview').treeview(options);
            });
        </script>
    </body>
</html>