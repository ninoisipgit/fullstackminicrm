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
                    <p>Email Notification for New Company</p>
					<p class="display-3">name of the company : {{$data['name']}}</p>
					<p class="display-3">website of the company: {{$data['email']}}</p>
					<p class="display-3">email of the company : {{$data['website']}}</p>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
