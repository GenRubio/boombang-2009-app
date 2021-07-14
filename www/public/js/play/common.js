function popUp(URL)
{
  var options = "";
  var direccion= URL;
  {
    var w = screen.width;
    var h = screen.height;
    var winw = 1012;
    var winh = Math.min(657, h - 110);
    var winl = (w - winw)/2;
    var wint = (h -winh)/2;
    options="toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width="+winw+",height="+winh+",left="+winl+",top ="+wint;
   }
   pararPeliculaJS();
   var win = window.open(direccion, 'BoomBang', options);
   win.focus();
   return false;
}

function popUpLegal(URL)
{
	var direccion = URL;
	var options="toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,width=400,height=500";
	var win = window.open(direccion, 'BoomBangL', options);
	win.focus();
}

function addEvent(target, event, func)
{
	if (!target) return false;
	if (typeof target.addEventListener != 'undefined')
	{
		target.addEventListener(event, func, false);
	}
	else if (typeof target.attachEvent != 'undefined')
	{
		target.attachEvent('on' + event, func);
	}
}

function addBookmark(url, title)
{
	if (navigator.userAgent.indexOf('MSIE') != -1)
	{
		window.external.AddFavorite(url, title);
	}
	else if (navigator.userAgent.indexOf('Firefox') != -1)
	{
		window.sidebar.addPanel(title, url, '');
	}
}

function pararPeliculaJS()
{
	var movie = conseguirMovie("top_flash");
	if (movie && movie.pararPelicula)
	{
		movie.pararPelicula();
	}
}
 
function reactivarPeliculaJS()
{
	var movie = conseguirMovie("top_flash")
	if (movie && movie.activarPelicula)
	{
		movie.activarPelicula();
	}
}
 
function conseguirMovie(movieName)
{
	if (window.document[movieName]) 
	{
		return window.document[movieName];
	}
	if (navigator.appName.indexOf("Microsoft Internet")==-1)
	{
		if (document.embeds && document.embeds[movieName])
		{
			return document.embeds[movieName];
		}
	}
	else // if (navigator.appName.indexOf("Microsoft Internet")!=-1)
	{
		return document.getElementById(movieName);
	}
}

function facebook_sharbs_click() 
{
	u=location.href;
	t=document.title;
	window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');
	return false;
}
