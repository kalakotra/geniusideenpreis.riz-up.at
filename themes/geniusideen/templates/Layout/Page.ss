<div class="container">
	<div class="row">
		<div class="col-12 col-md-7 col-lg-8">
			<article>
				<% if getCurrentUser && ClassName!="JugendpreisPage" %>
					<div class="content">
						<h3>User Manual</h3>
						<% loop userManual %>
							<a href="$Link">$Title</a> &nbsp; 
						<% end_loop %>
					</div>
					<hr />
				<% end_if %>
				
				<div class="content">$Content</div>
				$Form
			</article>
		</div>
		<div class="col-12 cl-md-5 col-lg-4">
			<% if AnsprechPartner %>
				<% include SideBar %>
			<% end_if %>
		</div>
	</div>
</div>