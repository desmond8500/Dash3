# Diagram

```mermaid
classDiagram

class Client{
    string name
    text description
    string address
    string avatar
    boolean status
    boolean type
}

Client <-- Projet
class Projet{
    int client_id
    string name
    string description

}

Projet <-- Invoice
class Invoice{
    int projet_id
    string client
    string projet
    string reference
    text modalite
    text description
    string tva
    string brs
    string remise
    string tva

}

Invoice <-- InvoiceDoc
class InvoiceDoc{
    int invoice_id
    string folder
    string type
}

Achats <-- AchatRow
class Achats{
    int provider_id
    string name
    text description
    date date
}
class AchatRow{
    int achat_id
    string designation
    string reference
    int quantite
    decimal prix
    decimal tva
}
class Provider{
    string name
    string logo
    string address
}

class Journal{
    int client_id
    int projet_id
    int devis_id
    int user_id
    string title
    text description
    date date
}

```



