import os, shutil
for x in os.walk('.'):
    print x[0]
    if x[0] != '.':
        with open('./' + x[0] + '.html', 'w') as file:
            file.write('<html></html>')
        shutil.rmtree(x[0])
