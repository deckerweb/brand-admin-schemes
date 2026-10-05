#!/usr/bin/env python3
"""Generate host catalogs and glossary from the maintained EN/DE source."""
from pathlib import Path
import json,struct
P=Path(__file__).resolve().parents[1];data=json.loads((P/'docs/source/messages.json').read_text());version=json.loads((P/'docs/source/content.json').read_text())['version']
def compile_mo(messages):
 ids=b'';strings=b'';ki=[];vi=[]
 for k in sorted(messages):
  a=k.encode();b=messages[k].encode();ki.append((len(a),len(ids)));vi.append((len(b),len(strings)));ids+=a+b'\0';strings+=b+b'\0'
 n=len(messages);base=28+16*n;second=base+len(ids)
 return struct.pack('<7I',0x950412de,0,n,28,28+8*n,0,base)+b''.join(struct.pack('<2I',l,base+o)for l,o in ki)+b''.join(struct.pack('<2I',l,second+o)for l,o in vi)+ids+strings
for locale in ['de_DE','de_DE_formal']:
 d={k:v[locale]for k,v in data.items()};assert all(d.values())
 d['']='Project-Id-Version: Brand Admin Schemes '+version+'\nPO-Revision-Date: 2026-10-05 16:00+0200\nLast-Translator: David Decker – DECKERWEB\nLanguage: '+locale+'\nContent-Type: text/plain; charset=UTF-8\nPlural-Forms: nplurals=2; plural=(n != 1);\n'
 base=P/'languages'/('brand-admin-schemes-'+locale)
 base.with_suffix('.po').write_text('\n\n'.join('msgid '+json.dumps(k,ensure_ascii=False)+'\nmsgstr '+json.dumps(v,ensure_ascii=False)for k,v in sorted(d.items()))+'\n')
 base.with_suffix('.mo').write_bytes(compile_mo(d))
(P/'languages/brand-admin-schemes.pot').write_text('\n\n'.join('msgid '+json.dumps(k,ensure_ascii=False)+'\nmsgstr ""'for k in sorted(data))+'\n')
terms=['Color scheme','Brand strength','Mood','Changelog','Save all changes','Website browser tab','WordPress admin browser tab','Builder editor browser tab','Your colors. Your WordPress.','Complete changelog','Unpublished test build']
rows='| EN | Deutsch (Du) | Deutsch (Sie) |\n|---|---|---|\n'
for k in terms:
 if k in data:rows+='| '+k+' | '+data[k]['de_DE']+' | '+data[k]['de_DE_formal']+' |\n'
rows+='| Site Icon | Website-Icon | Website-Icon |\n| palette provider | Paletten-Provider | Paletten-Provider |\n| Undo | Rückgängig | Rückgängig |\n| agency package | Agentur-Paket | Agentur-Paket |\n| network admin | Netzwerk-Admin | Netzwerk-Admin |\n'
for lang in ['en','de']:
 title='# Language glossary\n\n[Deutsch](GLOSSARY-de.md)\n\nUS English is the source. Informal German uses Du; formal German uses Sie and Ihr. Neutral labels remain identical. Technical identifiers and product names are never translated.\n\n'if lang=='en'else'# Sprachglossar\n\n[English](GLOSSARY.md)\n\nUS-Englisch ist die Quelle. Deutsch mit Du und Deutsch mit Sie werden vollständig ausgeliefert. Neutrale Beschriftungen bleiben identisch; technische Kennungen und Produktnamen bleiben unverändert.\n\n'
 (P/('docs/GLOSSARY.md'if lang=='en'else'docs/GLOSSARY-de.md')).write_text(title+rows)
print(len(data),'host messages compiled in informal/formal German; glossary generated.')
