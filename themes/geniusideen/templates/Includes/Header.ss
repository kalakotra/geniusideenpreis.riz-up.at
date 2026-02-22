<header class="header" >
	<div class="container">
		<div class="row ">
			<div class="col-6 col-md-4 col-lg-2">
				<a href="home/"><img src="$themedResourceURL('/images/riz-up-logo-2021.svg')" alt="RIZ logo" class="logo" /></a>
			</div>
			<div class="col-6 col-md-4 col-lg-2">
				<img src="$themedResourceURL('/images/genius_logo_2025_blau.png')" alt="RIZ logo" class="logo pb-2" />
			</div>
			<div class="col-6 col-md-4 col-lg-8 text-right">
				<div class="row h100">
					<% if getCurrentUser %>
						<div class="col-12 text-right">
							User: $getCurrentUser.Name
							<a href="Security/logout?BackURL=/home/" class="ml-3"> > Logout</a>
						</div>
					<% end_if %>
					<div class="col-12 align-self-end">
						<h1 class="headerTitle rizblue text-right">Einreichplattform</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>