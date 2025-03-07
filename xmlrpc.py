import xmlrpc.client
url = "https://mytek.odoo.com"
db = "mytek"
username = 'fbdigitalsarl@gmail.com'
password = "odoo@2024"

common = xmlrpc.client.ServerProxy('{}/xmlrpc/2/common'.format(url))
models_origine = xmlrpc.client.ServerProxy('{}/xmlrpc/2/object'.format(url))
print(common.version())

uid = common.authenticate(db,username,password, {})

url_destination = "http://192.168.1.221:8016"
db_destination = "demo"
username_destination = 'demo'
password_destination = "demo"

common_destination = xmlrpc.client.ServerProxy('{}/xmlrpc/2/common'.format(url_destination))
models_destination = xmlrpc.client.ServerProxy('{}/xmlrpc/2/object'.format(url_destination))
print(common_destination.version())

uid_destination = common_destination.authenticate(db_destination,username_destination,password_destination, {})


if uid:
    models = xmlrpc.client.ServerProxy('{}/xmlrpc/2/object'.format(url))

    partners = models_origine.execute_kw(db, uid, password, 'account.move', 'search',
                                 [[['invoice_date','>=','2024-01-01'], ['invoice_date','<=','2024-02-20'] ]], {'limit': 1000})
    print(partners)

    partner_rec = models_origine.execute_kw(db, uid, password, 'account.move', 'read', [partners],
        {'fields': ['name', 'invoice_partner_display_name', 'invoice_date']})
    total_count = 0
    for facture in partner_rec:
        print(facture)
        total_count +=1
        #new_facture = models_destination.execute_kw(db_destination, uid_destination, password_destination, 'tstock.factures', 'create', [facture])
        #new_facture = models_destination.execute_kw(db_destination, uid_destination, password_destination, 'account.move', 'create', [facture])
    print(total_count)

