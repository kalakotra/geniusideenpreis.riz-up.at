<div class="<% if $Fields.dataFieldByName($Vorname).Value!='' %><% else %>teamMemberBlock<% end_if %>">
	<div class="row align-items-center mb-1">
		<div class="col-12 col-lg-4">
			Anrede
		</div>
		<div class="col-12 col-lg-8">
			$Fields.dataFieldByName($Anrede).FieldHolder
		</div>
	</div>
	<div class="row align-items-center mb-1">
		<div class="col-12 col-lg-4">
			Titel vorangestellt
		</div>
		<div class="col-12 col-lg-8">
			$Fields.dataFieldByName($AkademischerGrad).FieldHolder
		</div>
	</div>
	
	<div class="row align-items-center mb-1">
		<div class="col-12 col-lg-4">
			Vorname
		</div>
		<div class="col-12 col-lg-8">
			$Fields.dataFieldByName($Vorname).FieldHolder
		</div>
	</div>
	<div class="row align-items-center mb-1">
		<div class="col-12 col-lg-4">
			Nachname
		</div>
		<div class="col-12 col-lg-8">
			$Fields.dataFieldByName($Nachname).FieldHolder
		</div>
	</div>
	<div class="row align-items-center mb-1">
		<div class="col-12 col-lg-4">
			Titel nachgestellt
		</div>
		<div class="col-12 col-lg-8">
			$Fields.dataFieldByName($AkademischerGradSufix).FieldHolder
		</div>
	</div>
	<hr />
</div>