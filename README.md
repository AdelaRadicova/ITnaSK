# ITnaSK

> [!TIP]
> Pre zobrazenie webovej stránky bez nutnosti "rozbehávania" projektu si môžete pozrieť ukážky stránky v rámci dokumentácie v bakalárskej práci v súbore *BP_Radicova_111425.pdf*, ktorý je súčasťou repozitára.

> [!NOTE]
> Všetky JavaScript skripty sú dostupné v podpriečinku *scripts*


## O projekte

Webová stránka "**Študuj IT na Slovensku!**" bola vytvorená v rámci bakalárskej práce. Téma bola vlastná, vytvorená s cieľom sprostredkovať stredoškolákom a celkovo záujemcom o štúdium informačných technológií na slovenských univerzitách všetky potrebné informácie na jednom mieste a pomôcť im tak s výberom tej správnej fakulty.

Webová stránka obsahuje podstránky pre vysoké školy na Slovensku, ich fakulty a príslušné študijné programy, ktoré sú zamerané na IT. V rámci nich sa návštevník dozvie všetky potrebné informácie ohľadom prijímacích pohovorov, nákladov na štúdium, či samotný obsah výučby v rámci konktétnych študijných programov.

Webová stránka takisto obsahuje sekciu pre komentáre/recenzie ku každému študijnému programu, kde študenti, či absolventi môžu zanechať slovné hodnotenie (v rámci dotazníka, ktorý pozostáva z konkrétnych otázok) na daný študijný program a sprostredkovať tak ich skúsenosť takpovediac z prvej ruky.


## Štruktúra projektu

Repozitár  obsahuje zdrojové kódy pre hlavné podstránky webovej stránky, ďalej je členený na nasledovné pod-priečinky :

1. *upload_pictures* – priečinok obsahuje obrázky-logá použité na webovej stránke
    * thumbnails
      * vs
      * fakulty

2. *styles* – priečinok obsahuje zdrojové kódy, ktoré súvisia s úpravou a dizajnom webovej stránky

3. *scripts* – priečinok obsahuje JavaScript skripty, ktoré sú spojené s funkcionalitou webovej stránky

4. *include_files* – priečinok obsahuje zdrojové kódy pre elementy, ktoré sa na webovej stránke vyskytujú opakovane (napr. hlavička, pätička, navigačné menu), ale aj zdrojové kódy spojené s funkcionalitou hlavných elementov na stránke, ako filter, a sekcia pre komentáre

5. *img_style* – priečinok obsahuje favicon súbory

6. *ckeditor* – priečinok obsahuje zdrojové súbory ku editoru, ktorý bol použitý

7. *admin_system* – priečinok obsahuje zdrojové kódy pre funkcionalitu administračného rozhrania webovej stránky
   * vs
   * studijnyProgram
   * komentare
   * fakulta
   * clanky

8. *dbs* – priečinok obsahuje súbor s prihlasovacími údajmi do administračného rozhrania a export dát z databázy


## Inštalačná príručka

Na otestovanie riešenia, resp. zobrazenie webovej stránky a otestovanie jej funkcionalít je potrebné mať dostupný webový server a databázu. Riešenie bolo vyvíjané aj následne nasadené na server
**Apache** spolu s databázou **MariaDB**.

Jedným zo spôsobov, ako si zaobstarať potrebný webový server, v prípade, že ho nemáte, je použitie voľne dostupného softvéru, ktorý server spolu s databázou sprostredkúva. Jednou
z dostupných alternatív takéhoto softvéru je napríklad **XAMPP 9** . Po stiahnutí a inštalácii daného softvéru sa v počítači vytvorí priečinok pod názvom xampp (zvyčajne na disku C), ktorý
obsahuje potrebné súbory pre prevádzku lokálneho webového servera a databázy. Podpriečinok */xampp/htdocs* je vyhradený pre projekty resp. zdrojové súbory webových stránok
a aplikácií, ktoré chceme zobrazovať. Sem je potrebné presunúť (nakopírovať) obsah repozitára **ITnaSK** ktorý obsahuje zdrojové kódy webovej stránky. 

Pozor, ak do priečinku htdocs presuniete obsah repozitára ITnaSK ako jeden priečinok a nie tak, ako je štrukturovaný v repozitári, stránka sa nezobrazí korektne!

V nasledujúcom kroku je potrebné server a databázu pomocou aplikácie **XAMPP** spustiť a prihlásiť sa do databázy pomocou rozhrania **phpMyAdmin**, ktoré je na to určené.

Ďalej je potrebné si vytvoriť databázu s názvom „**it_na_sk**“, do ktorej je následne možné pomocou priloženého súboru */dbs/it_na_sk_latest_export.sql* naimportovať potrebné dáta.

Nezabudnúť v súbore */include_files/dbs.php* zmeniť/prepísať prihlasovacie údaje v premenných ```$dbUsername``` a ```$dbPassword``` na údaje korešpondujúce prihlasovacím údajom ku svojej vlastnej databáze.

Pre prístup do administračného prostredia webovej stránky, do ktorého je možné sa dostať cez odkaz „**Admin**“ v pätičke webovej stránky, je potrebné použiť prihlasovacie údaje, ktoré sú dostupné v súbore */dbs/prihlasovacie_udaje_databaza.txt*.
