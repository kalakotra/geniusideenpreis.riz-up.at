<div class="container">
	<div class="row">
		<div class="col-12 col-md-7 col-lg-8">
			<div class="content">
				<a href="$Link">< Zur&uuml;ck zur &Uuml;bersicht</a>
			</div>
			<% loop me %>
				<% include ProjectPreview %>
			<% end_loop %>
		</div>
		<div class="col-12 col-md-5 col-lg-4">
			<% include SideBoxJury %>
		</div>
	</div>
</div>
<div class="formConfirmationHolder lightyellow pt-3 pb-3 hideOnPrint">
	<div class="container">
		<div class="row">
			<div class="col-12 hideOnPrint">
				<% if getJuryStatusForFrontendInteger==0 %>
					<button type="button" data-toggle="modal" data-target="#akzeptierenPopup" class="btn btn-primary">Projekt akzeptieren</button>
					<button type="button" data-toggle="modal" data-target="#abgelehntPopup" class="btn btn-secondary d-none">Projekt ablehnen</button>

					<!-- Modal akzeptierenPopup -->
					<div class="modal fade" id="akzeptierenPopup" tabindex="-1" role="dialog" aria-labelledby="akzeptierenPopupLabel" aria-hidden="true">
					  <div class="modal-dialog" >
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="akzeptierenPopupLabel">Bewertung GENIUS Ideenpreis</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        <p>
								Projekt akzeptiert
							</p>
							<p>
								M&ouml;chten Sie das Projekt jetzt bewerten oder sp&auml;ter?
							</p>
					      </div>
					      <div class="modal-footer">
					        <a href="$Link/projectAcept/$me.ID/rate" class="btn btn-secondary">Jetzt bewerten</a>
							<a href="$Link/projectAcept/$me.ID/" class="btn btn-secondary">Sp&auml;ter bewerten</a>
					      </div>
					    </div>
					  </div>
					</div>

					<!-- Modal abgelehntPopup -->
					<div class="modal fade" id="abgelehntPopup" tabindex="-1" role="dialog" aria-labelledby="abgelehntPopupLabel" aria-hidden="true">
					  <div class="modal-dialog" >
					    <div class="modal-content">
					    	<form action="$Link/projectReject/$me.ID" method="post" id="projectRejectForm">
							      <div class="modal-header">
							        <h5 class="modal-title" id="abgelehntPopupLabel">Bewertung GENIUS Ideenpreis</h5>
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          <span aria-hidden="true">&times;</span>
							        </button>
							      </div>
							      <div class="modal-body">
							        <h3>Projekt abgelehnt</h3>
									<p>
										Bitte nennen Sie uns den Grund, warum Sie das Projekt nicht bewerten k&ouml;nnen.
									</p>
									<div>
										<div class="floatLeft marginRight20">Begr&uuml;ndung *</div>
										<textarea required name="rejectionText" class="rejectionText"></textarea>
									</div>
							      </div>
							      <div class="modal-footer">
							        <input type="submit" value="Speichern" class="btn btn-secondary" />
									<input type="button" value="Abrechen" class="btn btn-secondary" data-dismiss="modal" aria-label="Close" />
							      </div>
							  </form>
					    </div>
					  </div>
					</div>
				<% end_if %>

				<% if getJuryStatusForFrontendInteger==1 || getJuryStatusForFrontendInteger==2 %>
					<a href="$Link/projectRate/$me.ID" class="btn btn-primary">Bewerten</a>
				<% end_if %>

				<% if getJuryStatusForFrontendInteger==3 %>
					<a href="$Link/projectRate/$me.ID" class="btn btn-primary ">Bewertungsvorschau</a>
				<% end_if %>
			</div>
		</div>
	</div>
</div>
