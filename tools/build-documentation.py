#!/usr/bin/env python3
"""Build EN/DE documentation and runtime history from one maintained source."""
from pathlib import Path
import json,re
P=Path(__file__).resolve().parents[1]
D=json.loads((P/'docs/source/content.json').read_text());H=D['history']
# Seven latest versions, expanded through two documented feature versions.
count=7
while count<len(H) and sum(1 for h in H[:count] if h['status']!='development' and h['version'].endswith('.0'))<2:count+=1
short=H[:count];categories={'en':{'New':'New','Improved':'Improved','Fix':'Fix','Misc':'Misc'},'de':{'New':'Neu','Improved':'Verbessert','Fix':'Behoben','Misc':'Sonstiges'}}
def label(h,lang):
 suffix=(' (development)' if lang=='en' else ' (Entwicklung)')
 return h.get('label',{}).get(lang,h['version'])+(suffix if h['status']=='development' else '')
def date(h,lang):
 if h['status']=='prepared':return 'Release prepared; publication pending' if lang=='en' else 'Release vorbereitet; Veröffentlichung steht noch aus'
 if h['date']:return h['date']+(' · test build, unpublished' if lang=='en' else ' · Teststand, unveröffentlicht') if h['status']=='development' else h['date']
 return 'Release date not recorded' if lang=='en' else 'Veröffentlichungsdatum nicht dokumentiert'
def history(items,lang,txt=False):
 key='en' if lang=='en' else 'de_DE';out=[]
 for h in items:
  out.append(('= '+label(h,lang)+' =' if txt else '### '+label(h,lang))+'\n\n'+date(h,lang)+'\n')
  for a in h['entries']:
   c=categories[lang][a['category']];out.append(('* '+c+': ' if txt else '- **'+c+':** ')+a[key])
  out.append('')
 return '\n'.join(out)
def text_readme(md):
 # Keep usable Markdown links; WordPress parses the WP headings and bullets.
 md=re.sub(r'^> .*\n','',md,flags=re.M)
 md=re.sub(r'^# [^\n]+\n','',md,flags=re.M)
 md=re.sub(r'^!\[.*\]\(.*\)\s*\n','',md,flags=re.M)
 md=re.sub(r'^\*\*Version:\*\*.*\n','',md,flags=re.M)
 md=re.sub(r'^<a name=.*\n','',md,flags=re.M)
 md=re.sub(r'^## (Contents|Inhaltsverzeichnis)\n.*?(?=^## )','',md,flags=re.M|re.S)
 md=re.sub(r'^## (Installation and first scheme|Installation und erstes Schema)$','## Installation',md,flags=re.M)
 md=re.sub(r'^## (FAQ|Häufige Fragen)$','## Frequently Asked Questions',md,flags=re.M)
 md=re.sub(r'^### (.+)$',r'= \1 =',md,flags=re.M)
 md=re.sub(r'^## (.+)$',r'== \1 ==',md,flags=re.M)
 md=re.sub(r'^\*\*(.+?\?)\*\* (.+)$',r'= \1 =\n\2',md,flags=re.M)
 md=re.sub(r'^- \*\*([^*]+):\*\*',r'* \1:',md,flags=re.M)
 return md.strip()+'\n'
for lang in ['en','de']:
 r=D['readmes'][lang];fullurl='https://github.com/deckerweb/brand-admin-schemes/wiki/FAQ-'+('English'if lang=='en'else'Deutsch')
 faq=('## FAQ'if lang=='en'else'## Häufige Fragen')+'\n\n'+'\n\n'.join('**'+q['question']+'** '+q['answer']for q in r['faq'])+'\n\n'+('[More answers by topic]'if lang=='en'else'[Alle Fragen nach Themen]')+'('+fullurl+')\n'
 note='The recent history extends beyond seven entries to include two documented feature versions; older prototypes have no verified release date.'if lang=='en'else'Der jüngste Verlauf umfasst mehr als sieben Einträge, um zwei dokumentierte Funktionsversionen zu zeigen; ältere Prototypen haben kein belegtes Veröffentlichungsdatum.'
 if count==7:note='Seven recent versions; the Wiki and local full history retain all documented entries.' if lang=='en' else 'Sieben jüngste Versionen; Wiki und lokaler vollständiger Verlauf erhalten alle dokumentierten Einträge.'
 screenshot='## Screenshots\n\n'+'\n\n'.join(str(i+1)+'. '+item['caption']+'\n\n!['+item['caption']+']('+item['path']+')' for i,item in enumerate(r.get('screenshots',[])))+'\n\n' if r.get('screenshots') else ''
 prefix=r['prefix']
 if D.get('publication_state')=='released':prefix=re.sub(r'^> .*\n\n','',prefix,count=1)
 md=prefix.replace('{{FAQ}}',faq)+screenshot+'## Changelog\n\n'+note+'\n\n'+history(short,lang)+'\n'+r['suffix']
 (P/('README.md'if lang=='en'else'README-de.md')).write_text(md)
 header='=== Brand Admin Schemes ===\nContributors: deckerweb\nTags: admin colors, branding, login, favicon, gutenberg\nRequires at least: 6.4\nRequires PHP: 8.0\nTested up to: 7.1.2\nStable tag: '+D['version']+'\nLicense: GPLv2 or later\nLicense URI: https://www.gnu.org/licenses/gpl-2.0.html\n\n'
 (P/('readme.txt'if lang=='en'else'readme-de.txt')).write_text(header+('Brand colors for the WordPress admin, login, toolbar and browser tabs.' if lang=='en' else 'Markenfarben für WordPress-Admin, Login, Toolbar und Browser-Tabs.')+'\n\n== Description ==\n\n'+text_readme(md))
 other='[Deutsch](CHANGELOG-de.md)'if lang=='en'else'[English](CHANGELOG.md)'
 full='# Changelog\n\n'+other+'\n\n'+history(H,lang)
 (P/('docs/CHANGELOG.md'if lang=='en'else'docs/CHANGELOG-de.md')).write_text(full)
 (P/('docs/changelog.txt'if lang=='en'else'docs/changelog-de.txt')).write_text('== Changelog ==\n\n'+history(H,lang,True))
 wiki='# Changelog\n\n[English](https://github.com/deckerweb/brand-admin-schemes/wiki/Changelog-English) · [Deutsch](https://github.com/deckerweb/brand-admin-schemes/wiki/Changelog-Deutsch)\n\n'+history(H,lang)
 (P/('docs/wiki/Changelog-English.md'if lang=='en'else'docs/wiki/Changelog-Deutsch.md')).write_text(wiki)
 (P/('docs/wiki/FAQ-English.md'if lang=='en'else'docs/wiki/FAQ-Deutsch.md')).write_text(D['wiki_faq'][lang])
 state=D.get('publication_state','development')
 notice=('Release prepared; publication is pending.' if lang=='en' else 'Release vorbereitet; Veröffentlichung steht noch aus.') if state=='prepared' else (('Published release.' if lang=='en' else 'Veröffentlichter Release.') if state=='released' else ('Unpublished test build; not a production release.' if lang=='en' else 'Unveröffentlichter Teststand; keine Produktionsfreigabe.'))
 notes='# Brand Admin Schemes '+D['version']+'\n\n'+notice+'\n\n'+history(H[:1],lang)
 notes+='\n'+('Requires WordPress 6.4+ and PHP 8.0+. Update from the WordPress Plugins screen or upload the release ZIP via Plugins → Add New → Upload Plugin. Branding, media and personal color choices are retained.' if lang=='en' else 'Benötigt WordPress 6.4+ und PHP 8.0+. Aktualisiere über die WordPress-Pluginseite oder lade das Release-ZIP unter Plugins → Installieren → Plugin hochladen hoch. Branding, Medien und persönliche Farbauswahl bleiben erhalten.')+'\n'
 notes+='\n'+('[Deutsch](RELEASE-NOTES-de.md)'if lang=='en'else'[English](RELEASE-NOTES.md)')+'\n'
 (P/('RELEASE-NOTES.md'if lang=='en'else'RELEASE-NOTES-de.md')).write_text(notes)
(P/'docs/history.json').write_text(json.dumps({'display_count':count,'versions':H},ensure_ascii=False,indent=2)+'\n')
print('Generated paired readmes, full history, wiki FAQ, release notes;',count,'recent versions.')
