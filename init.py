
def writeSessings(f,dic,title):
    str = ' \n /* ' + title + ' */ \n\n'
    f.write(str)

    for key in dic:
        str = 'const ' + key + ' = "' + dic[key] + '";\n'
        f.write(str)

main_path = {'BASE_URL':'/SNEMA_LK_V_4/'}
settings_1c = {'USER_1C':'web', 'PASS_1C':'passwd0', 'IP_SERVER_1C': '192.168.42.5', 'URL_1C':'/test/hs/exchange/'}
settings_sql = {'IP_SRV':'localhost','SQL_DB':'SNEMA','SQL_USER':'root','SQL_PASS':'Malder'}

f = open('settings.php','w')
f.write('<?php')

writeSessings(f,main_path,'main')
writeSessings(f,settings_1c,'1C')
writeSessings(f,settings_sql,'SQL')


