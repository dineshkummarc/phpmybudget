<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:import href="commun.xsl"/>
	<xsl:import href="statistiques_commun.xsl"/>
	<xsl:import href="template_name.xsl"/>
	<xsl:template name="js.module.sheet">
		<script type="text/javascript" src="front/js/statistiques.js" charset="iso-8859-1">&#160;</script>
		<script type="text/javascript" src="front/js/statistiquesCumul.js" charset="iso-8859-1">&#160;</script>
	</xsl:template>
	<xsl:template name="controleMenu">N</xsl:template>
	<xsl:template name="Contenu">
		<xsl:call-template name="boiteDetail"/>
		<center>
			<a href="index.php?domaine=statistique&amp;numeroCompte={$NUMEROCOMPTE}">Retour</a><br/>
			<div class="row">
				<div class="col-xs-offset-4 col-xs-4">
					<form class="form-group row"  method="POST" action="#" onsubmit="return soumettreMois(this);" name="formulaire" id="formulaire">
						<input name="numeroCompte" id="numeroCompte" type="hidden" value="{$NUMEROCOMPTE}"/>
						<fieldset>
							<div class="form-group row">
								<label for="premiereAnnee" class="col-sm-4 form-control-label"><xsl:value-of select="$LBL.PREMIERMOIS"/></label>
								<div class="col-sm-3">
									<input id="periodeListe"/>

								</div>
							</div>



							<div class="form-group row">
								<div class="text-center">
									<button type="submit" class="btn btn-primary">Valider</button>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
			<table id="tableResultat" name="tableResultat" class="table table-bordered"  table-hover=""/>
		</center>
	</xsl:template>
	<xsl:template match="ListeAnnee">
		<xsl:param name="name"/>
		<xsl:param name="obligatoire"/>
		<select name="{$name}" id="{$name}" class="form-control">
			<xsl:if test="$obligatoire='O'">
				<xsl:attribute name="class">form-control obligatoire</xsl:attribute>
			</xsl:if>
			<option/>
			<xsl:apply-templates select="Dynamic"/>
		</select>
	</xsl:template>
	<xsl:template match="Dynamic">
		<option value="{annee}">
			<xsl:value-of select="annee"/>
		</option>
	</xsl:template>
</xsl:stylesheet>
