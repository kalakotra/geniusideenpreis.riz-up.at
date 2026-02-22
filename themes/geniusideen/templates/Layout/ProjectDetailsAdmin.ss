<div class="container">
	<div class="row">
		<div class="col-12 col-md-7 col-lg-8">
			<article>
				<div class="content">$ProjectPreviewText</div>
	
				<% loop me %>
					<% include ProjectPreview %>
				<% end_loop %>
			</article>
		</div>
		<div class="col-12 cl-md-5 col-lg-4">
			<% include SideBoxJury %>
		</div>
	</div>
</div>

<!--- cloasing container to extend box to 100% --->
<div class="formConfirmationHolder lightyellow pt-3 pb-3 hideOnPrint">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<a href="javascript:window.print();" class="btn btn-secondary">Drucken</a>
			</div>
		</div>
	</div>
</div>