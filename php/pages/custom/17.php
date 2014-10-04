<h3>Краткая информация</h3>
<table class="spec">
<tbody>
<tr><th>Значение по умолчанию</th>
<td class="value">normal</td>
</tr>
<tr><th>Наследуется</th>
<td>Да</td>
</tr>
<tr><th>Применяется</th>
<td>Ко всем элементам</td>
</tr>
<tr><th>Ссылка на спецификацию</th>
<td><a href="http://www.w3.org/TR/CSS21/fonts.html#propdef-font-weight">http://www.w3.org/TR/CSS21/fonts.html#propdef-font-weight</a></td>
</tr>
</tbody>
</table>
<h3>Версии CSS</h3>
<table class="cssver">
<tbody>
<tr><th>CSS 1</th><th>CSS 2</th><th>CSS 2.1</th><th>CSS 3</th></tr>
<tr>
<td class="spec_yes">&nbsp;</td>
<td class="spec_yes">&nbsp;</td>
<td class="spec_yes">&nbsp;</td>
<td class="spec_yes">&nbsp;</td>
</tr>
</tbody>
</table>
<h3>Описание</h3>
<p>Устанавливает насыщенность шрифта. Значение устанавливается от 100 до 900 с шагом 100. Сверхсветлое начертание, которое может отобразить браузер, имеет значение 100, а сверхжирное &mdash; 900. Нормальное начертание шрифта (которое установлено по умолчанию) эквивалентно 400, стандартный полужирный текст &mdash; значению 700.</p>
<h3>Синтаксис</h3>
<p class="example">font-weight: bold|bolder|lighter|normal|100|200|300|400|500|600|700|800|900</p>
<h3>Значения</h3>
<p>Насыщенность шрифта задаётся с помощью ключевых слов: <span class="value">bold</span>&nbsp;&mdash; полужирное начертание, <span class="value">normal</span>&nbsp;&mdash; нормальное начертание. Также допустимо использовать условные единицы от 100 до 900. Значения <span class="value">bolder</span> и <span class="value">lighter</span> изменяют жирность относительно насыщенности родителя, соответственно, в большую и меньшую сторону.</p>
<p class="exampleTitle">Пример</p>
<p class="example-support"><span class="html yes">HTML5</span><span class="css yes">CSS2.1</span><span class="yes">IE</span><span class="yes">Cr</span><span class="yes">Op</span><span class="yes">Sa</span><span class="yes">Fx</span></p>
<div class="htmlbook-code">
<pre><code class=" html"><span class="doctype">&lt;!DOCTYPE html&gt;</span>
<span class="tag">&lt;<span class="keyword">html</span>&gt;</span>
 <span class="tag">&lt;<span class="keyword">head</span>&gt;</span>
  <span class="tag">&lt;<span class="keyword">meta</span><span class="attribute"> charset=<span class="value">"utf-8"</span></span>&gt;</span>
  <span class="tag">&lt;<span class="keyword">title</span>&gt;</span>font-weight<span class="tag">&lt;/<span class="keyword">title</span>&gt;</span>
  <span class="tag">&lt;<span class="keyword">style</span>&gt;</span><span class="css">
   <span class="keyword">h1</span> <span class="rules">{
    <span class="rule"><span class="keyword">font-weight</span>:<span class="value"> normal</span>;</span> <span class="comment">/* Нормальное начертание */</span>
   }</span> 
   <span class="class">.select</span> <span class="rules">{
    <span class="rule"><span class="keyword">color</span>:<span class="value"> maroon</span>;</span> <span class="comment">/* Цвет текста */</span>
    <span class="rule"><span class="keyword">font-weight</span>:<span class="value"> <span class="number">600</span></span>;</span> <span class="comment">/* Жирное начертание */</span>
   }</span>
  </span><span class="tag">&lt;/<span class="keyword">style</span>&gt;</span>
 <span class="tag">&lt;/<span class="keyword">head</span>&gt;</span>
 <span class="tag">&lt;<span class="keyword">body</span>&gt;</span>
  <span class="tag">&lt;<span class="keyword">h1</span>&gt;</span>Duis te feugifacilisi<span class="tag">&lt;/<span class="keyword">h1</span>&gt;</span>
  <span class="tag">&lt;<span class="keyword">p</span>&gt;</span><span class="tag">&lt;<span class="keyword">span</span><span class="attribute"> class=<span class="value">"select"</span></span>&gt;</span>Lorem ipsum dolor sit amet<span class="tag">&lt;/<span class="keyword">span</span>&gt;</span>, 
  consectetuer adipiscing elit, sed diem nonummy nibh euismod tincidunt ut lacreet 
  dolore magna aliguam erat volutpat. Ut wisis enim ad minim veniam, quis nostrud 
  exerci tution ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo
  consequat.<span class="tag">&lt;/<span class="keyword">p</span>&gt;</span>
 <span class="tag">&lt;/<span class="keyword">body</span>&gt;</span>
<span class="tag">&lt;/<span class="keyword">html</span>&gt;</span></code></pre>
<div class="example-view"><img class="example-win" title="Посмотреть в этом окне" src="http://htmlbook.ru/themes/hb/img/win.gif" alt="Посмотреть пример" /><br /><img class="example-win" title="Посмотреть в новом окне" src="http://htmlbook.ru/themes/hb/img/win2.gif" alt="Посмотреть пример" /></div>
</div>
<p>Результат данного примера показан на рис. 1.</p>
<p class="fig"><img src="http://htmlbook.ru/files/images/css/css_font-weight.png" alt="Применение свойства font-weight" width="424" height="273" /></p>
<p class="figsign">Рис. 1. Применение свойства font-weight</p>
<h3>Объектная модель</h3>
<p>[window.]document.getElementById("<span class="value">elementID</span>").style.fontWeight</p>
<h3>Браузеры</h3>
<p>Браузеры обычно не могут адекватно показать требуемую насыщенность шрифта, поэтому переключаются между значениями <span class="value">bold</span>, <span class="value">normal</span> и <span class="value">lighter</span>. На практике же начертание в браузерах обычно ограничено всего двумя вариантами: нормальное начертание и жирное начертание.</p>