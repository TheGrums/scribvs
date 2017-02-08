
<div class="container-fluid group-tool">
  <div class="row" style="margin-top:30px;">
    <div class="col-md-6 col-md-offset-3 col-xs-12">
        <div class="form-group" style="text-align:left;">
            <input class="form-control" id="new-group-name" placeholder="Nommez votre groupe" type="text">
            <div class="help-block">Choisissez un nom court et significatif. (ex: "Sc 5h 4EF")</div>
        </div>
    </div>
  </div>
  <div class="row" style="margin-bottom:10px;">
    <div class="col-sm-4 col-sm-offset-4">
      <span class="glyphicon glyphicon-chevron-down" style="font-size:1.6em;opacity:.2;"></span><br />
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 col-md-offset-3 col-xs-12">
        <div class="form-group" style="text-align:left;">
          <div class="input-group stylish-input-group">
            <input class="form-control" id="search-space-students" placeholder="Ajoutez des élèves" type="text">
            <span class="input-group-addon">
              <button>
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
          </div>
          <div class="help-block">Faites une recherche par groupe en commençant par @.(ex: "@4F")</div>

        </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-10 col-sm-offset-1" id="search-students-results">

    </div>
  </div>
  <div class="row" style="margin:10px 0px;">
    <div class="col-sm-4 col-sm-offset-4">
      <span class="glyphicon glyphicon-chevron-down" style="font-size:1.6em;opacity:.2;"></span><br />
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <div class="panel">
        <div class="panel-heading"><h5>Vérifiez la composition du groupe.</h5></div>
        <table class="table">
          <tbody id="group-preview">
            <tr>
            </tr>
          </tbody>

        </table>
      </div>
    </div>
  </div>
  <div class="row" style="margin:10px 0px;">
    <div class="col-sm-4 col-sm-offset-4">
      <span class="glyphicon glyphicon-chevron-down" style="font-size:1.6em;opacity:.2;"></span><br />
    </div>
  </div>
  <div class="row" style="margin-top:30px;">
    <div class="col-sm-2 col-sm-offset-4" onclick="deleteCreationTool();">
      <button class="btn btn-danger btn-lightbox" id="group-cancel">Annuler</button>
    </div>
    <div class="col-sm-2" onclick="sendNewGroupData();">
      <button class="btn btn-success btn-lightbox" id="group-create">Créer</button>
    </div>
  </div>
  <div class="row">
      <div class="col-sm-4 col-sm-offset-4">
        <div class="help-block" style="color:red;" id="grp-creator-error"></div>
      </div>
  </div>

</div>
