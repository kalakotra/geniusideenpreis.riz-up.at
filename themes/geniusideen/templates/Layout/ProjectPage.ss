<div class="container">
	<div class="row">
		<div class="col-12 col-md-7 col-lg-8">
			<article>
				<% if Inactive %>
					$InactiveText
				<% else %>
					$RegistrationForm
				<% end_if %>
			</article>
		</div>
		<div class="col-12 cl-md-5 col-lg-4">
			<% if AnsprechPartner %>
				<% include SideBar %>
			<% end_if %>
		</div>
	</div>
</div>