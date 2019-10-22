<!DOCTYPE html>
<html>
	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	    <title>Email Notification</title>

	    <style>
		    html{
		        margin:50px 25px;
		    }

		    body, head, textarea {
		        font-family: Times New Roman, Lucida Grande,Lucida Sans,Arial,sans-serif;
		        font-size: 9pt;
		    }

		    .tablespace {
		    	border-collapse: collapse;
			}

		    .tableborder {
		    	border: 1px solid black;
			}
		</style>
	</head>
	<body>
    <div style="page-break-inside:avoid !important;"></div>
		<div class="container">
			<div class="jumbotron">
				<div class="col-sm-12">
					<div class="aus-cont-body">
                    <p>Email Notification for {{$data['to_name']}}</p>
                    <p class="display-3">from : {{$data['from_name']}}</p>
					<p class="display-3">from email : {{$data['from_email']}}</p>
					<p class="display-3">Message : {{$data['message']}}</p>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
