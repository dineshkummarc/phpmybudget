<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:import href="commun.xsl"/>
    <xsl:import href="template_name.xsl"/>
    <xsl:import href="statistiques_commun.xsl"/>
    <xsl:param name="ANNEE">
        <xsl:choose>
            <xsl:when test="not(/root/request/annee)">
                <xsl:value-of select="substring(/root/date,1,4)"/>
            </xsl:when>
            <xsl:otherwise>
                <xsl:value-of select="/root/request/annee"/>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:param>
    <!-- template js -->
    <xsl:template name="js.module.sheet">
        <script type="text/javascript" src="application/js/previsions.js" charset="iso-8859-1">&#160;</script>
        <script language="JavaScript" src="application/js/statistiques.js" type="text/javascript"/>
    </xsl:template>
    <xsl:template name="Contenu">
        <xsl:call-template name="boiteUnitaire"/>
        <xsl:call-template name="boiteDetail"/>
        <xsl:call-template name="boiteListeEntete"/>

        <div class="row">
            <div class="col-lg-offset-4 col-lg-4">
                <table class="table table-bordered">
					<tr>
						<th colspan="2" class="text-center">
							<xsl:value-of select="concat($LBL.PREVISIONSCOMPTE, ' ', $NUMEROCOMPTE)"/>
						</th>
					</tr>
                    <tr>
						<th>
							<xsl:value-of select="$LBL.ANNEE"/>
						</th>
                        <td>
                            <select name="annee" id="annee" onchange="refreshWindow()">
                                <xsl:apply-templates select="/root/data/ListeAnnees/Dynamic">
                                    <xsl:with-param name="anneeSelect" select="$ANNEE"/>
                                </xsl:apply-templates>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>
							<xsl:value-of select="$LBL.ENTETE"/>
						</th>
						<td>
                            <input type="button" id="" name="" value="Entete"
                                   onclick="afficheEntete('{$NUMEROCOMPTE}');"/>
                            <select name="listeEntete" id="listeEntete" onchange="afficheListeGroupe(this.value)"/>
                        </td>
                    </tr>
                    <tr>
                        <th>
							<xsl:value-of select="$LBL.CREER"/>
						</th>
						<td>
                            <input type="button" id="" name="" value="Unitaire"
                                   onclick="afficheUnitaire('{$NUMEROCOMPTE}','');"/>

                        </td>
                    </tr>
					<tr>
                        <th>
							<xsl:value-of select="$LBL.SOLDE"/>
						</th>
                        <td>
                            <xsl:value-of
                                    select="format-number(number(/root/data/SommeOperations/Dynamic/total) + number(/root/data/Comptes/solde), $FORMAT_MNT)"/>
                        </td>
                    </tr>
                    <tr>
                        <th>
							<xsl:value-of select="$LBL.ESTIMATION"/>
						</th>
                        <td>
                            <span id="estimation" name="estimation" disabled="disabled"/>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <br/>
        <br/>
        <!--h1>
            <xsl:value-of select="concat($LBL.PREVISIONSCOMPTE, ' ', $NUMEROCOMPTE)"/>
        </h1-->
        <!--div class="row text-center">
            <div class="col-lg-4">
                <table class="table table-striped">
                    <tr>
                        <td>Solde</td>
                        <td>
                            <xsl:value-of
                                    select="format-number(number(/root/data/SommeOperations/Dynamic/total) + number(/root/data/Comptes/solde), $FORMAT_MNT)"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Estimation</td>
                        <td>
                            <span id="estimation" name="estimation" disabled="disabled"/>
                        </td>
                    </tr>
                </table>
            </div>
        </div-->
        <table class="table table-bordered " table-hover="" name="liste" id="liste"/>
        <form method="post" action="" name="formEntete" id="formEntete">
            <table id="tableEntete" name="tableEntete"/>
        </form>
    </xsl:template>
    <xsl:template name="boiteUnitaire">
        <div id="boite" title="{$LBL.EDITIONPREVISION}" style="display: none;">
            <form method="POST" name="editionPrevisionUnitaire" id="editionPrevisionUnitaire" action="index.php"
                  onsubmit="return modifierPrevision(this)">
                <input type="hidden" id="numeroCompte" name="numeroCompte" value="{$NUMEROCOMPTE}"/>
                <input type="hidden" id="typenr" name="typenr" value="L"/>
                <input type="hidden" id="ligneId" name="ligneId" value=""/>
                <input type="hidden" id="service" name="service"/>
                <div class="container popup_operation">
                    <div class="col-lg-12">
                        <div class="form-group row">
                            <label for="noReleve" class="col-sm-6 form-control-label">
                                <xsl:value-of select="$LBL.FLUX"/>
                            </label>
                            <div class="col-sm-6">
                                <xsl:call-template name="ListeFlux">
                                    <xsl:with-param name="liste" select="/root/data/ListeFlux"/>
                                    <xsl:with-param name="champ" select="'fluxId'"/>
                                    <xsl:with-param name="valeur" select="/root/data/Operation/fluxId"/>
                                    <xsl:with-param name="class" select="'obligatoire'"/>
                                    <xsl:with-param name="tabindex" select="'5'"/>
                                </xsl:call-template>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="date" class="col-sm-6 form-control-label">
                                <xsl:value-of select="$LBL.PERIODE"/>
                            </label>
                            <div class="col-sm-6">
                                <select name="mois" id="mois" tabindex="10" class="form-control">
                                    <option/>
                                    <xsl:for-each select="/root/data/ListePeriodes/Periode">
                                        <option value="{periode}">
                                            <xsl:value-of select="periode"/>
                                        </option>
                                    </xsl:for-each>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fluxId" class="col-sm-6 form-control-label">
                                <xsl:value-of select="$LBL.MONTANT"/>
                            </label>
                            <div class="col-sm-6">
                                <input size="7" name="montant" id="montant" class="form-control obligatoire"
                                       onblur="return isDouble(this);" tabindex="15"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4"/>
                            <div class="form-group row">
                                <div class="col-sm-offset-5 col-sm-5">
                                    <button type="submit" class="btn btn-primary"><xsl:value-of select="$LBL.MODIFIER"/></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!--table>
                    <tr>
                        <td>
                            <xsl:value-of select="$LBL.FLUX"/>
                        </td>
                        <td>
                            <xsl:call-template name="ListeFlux">
                                <xsl:with-param name="liste" select="/root/data/ListeFlux"/>
                                <xsl:with-param name="champ" select="'fluxId'"/>
                                <xsl:with-param name="valeur" select="/root/data/Operation/fluxId"/>
                                <xsl:with-param name="class" select="'obligatoire'"/>
                                <xsl:with-param name="tabindex" select="'5'"/>
                            </xsl:call-template>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <xsl:value-of select="$LBL.PERIODE"/>
                        </td>
                        <td>
                            <select name="mois" id="mois" tabindex="10">
                                <option/>
                                <xsl:for-each select="/root/data/ListePeriodes/Periode">
                                    <option value="{periode}">
                                        <xsl:value-of select="periode"/>
                                    </option>
                                </xsl:for-each>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <xsl:value-of select="$LBL.MONTANT"/>
                        </td>
                        <td>
                            <input size="7" name="montant" id="montant" class="numerique_obligatoire"
                                   onblur="return isDouble(this);" tabindex="15"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input type="submit" id="" name="" value="{$LBL.MODIFIER}"/>
                        </td>
                    </tr>
                </table-->
            </form>
        </div>
        <div id="boiteEntete" title="Edition" style="display: none;">
            <!--
                formulaire entete
            -->
            <form method="POST" name="editionEnteteUnitaire" id="editionEnteteUnitaire" action="index.php"
                  onsubmit="return creerEntete(this)">
                <input type="hidden" id="numeroCompte" name="numeroCompte" value="{$NUMEROCOMPTE}"/>
                <input type="hidden" id="typenr" name="typenr" value="E"/>
                <input type="hidden" id="ligneId" name="ligneId" value=""/>
                <input type="hidden" id="service" name="service" value="create"/>
                <table>
                    <tr>
                        <td>
                            titre
                        </td>
                        <td>
                            <input type="texte" id="nomEntete" name="nomEntete" tabindex="1"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <xsl:value-of select="$LBL.FLUX"/>
                        </td>
                        <td>
                            <xsl:call-template name="ListeFlux">
                                <xsl:with-param name="liste" select="/root/data/ListeFlux"/>
                                <xsl:with-param name="champ" select="'fluxId'"/>
                                <xsl:with-param name="valeur" select="/root/data/Operation/fluxId"/>
                                <xsl:with-param name="class" select="'obligatoire'"/>
                                <xsl:with-param name="tabindex" select="'5'"/>
                            </xsl:call-template>
                        </td>
                    </tr>
                    <tr>
                        <td>P�riodicit�</td>
                        <td>
                            <select name="periodicite" id="periodicite" class="obligatoire" tabindex="10">
                                <option/>
                                <option value="M">Mensuelle</option>
                                <option value="T1">Trimestre d�but</option>
                                <option value="T3">Trimestre fin</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <xsl:value-of select="$LBL.MONTANT"/>
                        </td>
                        <td>
                            <input size="7" name="montant" id="montant" class="numerique_obligatoire"
                                   onblur="return isDouble(this);" tabindex="15"/>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" align="center">
                            <input type="submit" class="bouton" id="" name="" value="{$LBL.MODIFIER}" tabindex="30"/>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </xsl:template>
    <!--
        template boite de dialogue liste des pr�visions par ent�te
    -->
    <xsl:template name="boiteListeEntete">
        <div id="boiteListeEntete" title="{$LBL.EDITIONLISTEPREVISION}" style="display: none;">
            <form method="post" action="" onsubmit="return enregistreListeLignes(this);">
                <input type="hidden" id="numeroCompte" name="numeroCompte" value="{$NUMEROCOMPTE}"/>
                <table id="tabListeEntete" name="tabListeEntete" width="80%" align="center">
                    <thead>
                    <tr>
                        <th>Mois</th>
                        <th>Montant</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody id="tbodylisteentete"/>
                    <tfoot>
                        <tr>
                            <td style="text-align:center;">
                                <input type="submit" class="bouton" id="" name="" value="{$LBL.MODIFIER}"/>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <!--table width="80%" align="center">

                </table-->
            </form>
        </div>
    </xsl:template>
    <xsl:template match="Dynamic">
        <xsl:param name="anneeSelect"/>
        <option value="{annee}">
            <xsl:if test="annee=$anneeSelect">
                <xsl:attribute name="selected">selected</xsl:attribute>
            </xsl:if>
            <xsl:value-of select="annee"/>
        </option>
    </xsl:template>
</xsl:stylesheet>
