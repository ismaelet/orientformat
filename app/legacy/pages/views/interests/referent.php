 <li class="school-type">
     <h3 class="school-type_title txt-sbold txt-15rem mx-auto"><?= $referent['name'] ?></h3>

     <p>In Trentino, il sistema degli Istituti Tecnologici Superiori (ITS Academy) è storicamente integrato nell'Alta
         Formazione Professionale (AFP). Per il 2026, il sistema si è evoluto verso il modello nazionale degli ITS
         Academy, offrendo percorsi post-diploma altamente specializzati in collaborazione con le aziende locali.</p>

     <ul class="mt-8 grid grid-cols-1 gap-2">
         <?php foreach ($referent['contacts'] as $label => $contact) { ?>
             <li class="">
                 <span class="font-bold"><?= $label ?>:</span> <?= $contact ?>
             </li>
         <?php } ?>
     </ul>
 </li>