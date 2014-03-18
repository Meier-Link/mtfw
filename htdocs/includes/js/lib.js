/**
 * lib.js
 *  Specific functions
 **/

/**
 * Global
 **/

/**
 * hide_unhide_ctt(ctt_id)
 *  Display selected page and hide others
 *  Main function who manage client display
 *  @param ctt_id: 'String' id of the target page
 */
function hide_unhide_ctt(ctt_id)
{
  if (ctt_id != undefined)
  {
    var all_ctt = document.querySelectorAll('#main div');
    for(j = 0; j < all_ctt.length; j++)
    {
      if (all_ctt[j].id != ctt_id)
        all_ctt[j].classList.remove('unhide');
      else
        all_ctt[j].classList.add('unhide');
    }
  }
}

/**
 * make_http_object
 *  Standard method to simplify server queries
 */
function make_http_object()
{
  try { return new XMLHttpRequest(); }
  catch (erreur) {}
  try { return new ActiveXObject("Msxml2.XMLHTTP"); }
  catch (erreur) {}
  try { return new ActiveXObject("Microsoft.XMLHTTP"); }
  catch (erreur) {}

  throw new Error("Unable to create HTTP query object due to an older browser or your browser configuration is too strict.");
}

/**
 * get_server_data(board, on_success)
 *  The main function to get server side data
 *  section:      aka controller name
 *  on_success:   a function which used to the result set
 *  post_params:  a set of post_param like {k: '<key>', v: '<val>'}
 *  template:     specify a different template from default (json)
 */
function get_server_data(section, on_success, post_params, template)
{
  var template  = template || 'json';
  var section   = section || 'index';
  var paramstr  = 'section=' + section + '&template=' + template;
  if(section.substr(0,1) != '/') section = '/' + section;
  if (post_params != undefined && post_params != null)
  {
    for (e in post_params)
    {
      console.log(e);
      paramstr += '&' + post_params[e].k + '=' + post_params[e].v;
    }
  }
  var query = make_http_object();
  answer = '';
  query.open('POST', section, true);
  query.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  query.setRequestHeader("Content-length", paramstr.length);
  query.setRequestHeader("Connection", "close");
  query.onreadystatechange = function (aEvt)
  {
    var logselector = document.getElementById('logs');
    logselector.innerHTML = "&nbsp;";
    if (query.readyState == 4)
    {
      var today = new Date;
      var fulltoday = "le " + today.toLocaleDateString() + " à " + today.toLocaleTimeString();
      if(query.status == 200)
      {
        /* Safe management of incoming data with JSON.parse (solve the case of "(JSON_data);") */
        if (template == 'json')
        {
          var tmp = query.responseText;
          console.log(tmp.substr(0,1));
          if (tmp.substr(0,1) == '(') tmp = tmp.substr(1, tmp.lenght-2);
          if (tmp.substr(tmp.lenght-1, 1) == ')') tmp = tmp.substr(0, tmp.lenght-1);
          var result = JSON.parse(tmp);
          on_success(result.res);
          for (i in result.log)
            logselector.insertAdjacentHTML('beforeend', '<div class="' + result.log[i].level + '">' + result.log[i].log + '</div>');
        }
        else
        {
          //window.location('') // TODO make redirection
        }
      }
      else
      {
        console.log("Erreur pendant le chargement de la page '" + section + "'.\n");
        var logmsg = '<div class="err">Impossible de recharger cette page. Le serveur semble être injoignable.'
          + ' <span>(' + fulltoday + ')</span></div>';
        logselector.insertAdjacentHTML('beforeend', logmsg);
      }
    }
  };
  query.send(paramstr);
  return answer;
}

/** Storage specific functions **/
storage = window.localStorage;

/**
 * function getItem(itemName)
 *  Simplify access to local storage, specifically to store non string objects
 *  @param itemName equivalent to database id
 *  @return obj the corresponding object
 */
function getItem(itemName)
{
  var obj;
  try
  {
    obj = JSON.parse(storage.getItem(itemName));
  }
  catch (e)
  {
    console.log(e)
    obj = storage.getItem(itemName);
  }
  return obj;
}

/**
 * function setItem(itemName)
 *  Simplify access to local storage, specifically to store non string objects
 *  @param itemName equivalent to database id
 *  @param obj      the object to store
 *  @return true if success, false otherwise
 */
function setItem(itemName, obj)
{
  if ((typeof itemName).toLowerCase() == "string")
  {
    storage.setItem(itemName, JSON.stringify(obj));
    return true;
  }
  else
  {
    throw "itemName must be a string";
  }
  return false;
}
