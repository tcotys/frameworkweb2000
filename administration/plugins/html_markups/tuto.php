<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Aide HTML</title>
  </head>
  <body>
    <h1>Balises HTML de base</h1>
       L'ensemble de ces balises sont reprise
      <a href="http://www.siteduzero.com/informatique/tutoriels/apprenez-a-creer-votre-site-web-avec-html5-et-css3/memento-1">sur ce site</a>
      <dl>
        <dt>Paragraphe</dt>
          <dd><pre>&lt;p&gt;Texte du paragraphe&lt;/p&gt;</pre> <small><p>Paragraphe</p><p>Un second paragraphe</p></small></dd>
        <dt>Passage à la ligne</dt>
          <dd><pre>&lt;br /&gt;</pre><small>texte<br/>texte à la ligne</small></dd>
        <dt>Mise en évidence normale (italique)</dt>
          <dd><pre>&lt;em&gt;Texte en évidence&lt;/em&gt;</pre>  <small>texte <em>Texte en évidence</em> suite du texte</small></dd>
        <dt>Mise en évidence forte (gras)</dt>
          <dd><pre>&lt;strong&gt;Texte en évidence&lt;/strong&gt;</pre>  <small>texte <strong>Texte en évidence</strong> suite du texte</small></dd>
        <dt>Citation (longue)</dt>
          <dd><pre>&lt;blockquote&gt;Citation en bloc&lt;/blockquote&gt;</pre><small>Texte <blockquote>Citation en bloc</blockquote>suite du texte</small></dd>
        <dt>Citation du titre d'une œuvre ou d'un évènement</dt>
          <dd><pre>&lt;cite&gt;Groupe cité&lt;cite&lt;/cite&gt;</pre><small>ou connais tous <cite>K-Davr</cite> qui fait de la musique</small></dd>
        <dt>Citation (courte)</dt>
          <dd><pre>&lt;q&gt;citation courte&lt;/q&gt;</pre><small>Il y a un mec qui a dit <q>Prout</q></small></dd>
        <dt>Titre</dt>
          <dd><pre>&lt;h1&gt;Titre de niveau 1&lt;/h1&gt; &lt;h2&gt;Titre de niveau 2&lt;/h2&gt; ... &lt;h6&gt;Titre de niveau 6&lt;/h6&gt;</pre>
            <h1>Titre de niveau 1</h1><h2>Titre de niveau 2</h2><h3>Titre de niveau 3</h3>
            <h4>Titre de niveau 4</h4><h5>Titre de niveau 5</h5><h6>Titre de niveau 6</h6></dd>
        <dt>Images</dt>
          <dd><pre>&lt;img width=largeur height=hauteur src="adresse de l'image" alt="titre de l'image" /&gt;
&lt;img width=100px height=30px src="../images/banniere.jpg" alt="Bannière du site" /&gt;</pre>
          <img width=100px height=30px src="../images/banniere.png" alt="Bannière du site" /><br />
          <small>L'adresse de l'image doit soit être un lien relatif, soit un lien absolu.
          Pour celle du site, il y a un généraleur de liens.<br/>
          Une image est inclue dans le texte, comme un caractère du texte.
          Si la largeur ou la hauteur n'est pas spécifié, l'image sera redimentionnée en gardant les proportions.
          Si aucun des deux n'est spécifié l'image est affichée avec sa taille initiale.</small></dd>
        <dt>Les liens</dt>
          <dd><pre>&lt;a href="destination du lien"&gt;Texte du lien&lt;/a&gt;
&lt;a href="http://www.kdavr.com/"&gt;Site de K-DAVR&lt;/a&gt;</pre>
          <small><a href="htp://www.kdavr.com/">Site de K-DAVR</a></small></dd>
        <dt>Ligne de séparation horizontale</dt>
          <dd><pre>&lt;hr /&gt;</pre><small><hr /></small></dd>
        <dt>Les tableau</dt>
          <dd><pre>
&lt;table&gt;
  &lt;tr&gt;
    &lt;td&gt;Cellule 1&lt;/td&gt;
    &lt;td&gt;Cellule 2&lt;/td&gt;
  &lt;/tr&gt;
  &lt;tr&gt;
    &lt;td&gt;Cellule 3&lt;/td&gt;
    &lt;td&gt;Cellule 4&lt;/td&gt;
  &lt;/tr&gt;
&lt;/table&gt;</pre>
            <table>
              <tr>
                <td>Cellule 1</td>
                <td>Cellule 2</td>
              </tr>
              <tr>
                <td>Cellule 3</td>
                <td>Cellule 4</td>
              </tr>
            </table>
            Commencer un tableau : table,<br />
            Commencer une ligne : tr<br />
            Commencer une colone dans la ligne : td<br/>
            <a href="http://www.siteduzero.com/informatique/tutoriels/apprenez-a-creer-votre-site-web-avec-html5-et-css3/un-tableau-simple">Plus d'info ici</a>
          </dd>
      <dt>Les listes non-numérotées</dt>
        <dd><pre>
&lt;ul&gt;
    &lt;li&gt;Element 1&lt;/li&gt;
    &lt;li&gt;Element 2&lt;/li&gt;
    &lt;li&gt;Element 3&lt;/li&gt;
&lt;/ul&gt;</pre>
          <ul>
            <li>Element 1</li>
            <li>Element 2</li>
            <li>Element 3</li>
          </ul></dd>
      <dt>Les listes numérotées</dt>
        <dd><pre>
&lt;ol&gt;
    &lt;li&gt;Element 1&lt;/li&gt;
    &lt;li&gt;Element 2&lt;/li&gt;
    &lt;li&gt;Element 3&lt;/li&gt;
&lt;/ol&gt;</pre>
          <ol>
            <li>Element 1</li>
            <li>Element 2</li>
            <li>Element 3</li>
          </ol></dd>
      </dl>
      <a href="http://www.siteduzero.com/informatique/tutoriels/apprenez-a-creer-votre-site-web-avec-html5-et-css3/memento-3">Liste des propriétés CSS</a>

  </body>
</html>