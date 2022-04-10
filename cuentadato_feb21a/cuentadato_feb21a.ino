#include <SPI.h>
#include <MFRC522.h>
#include <ESP8266WiFi.h>
#include <WiFiClient.h>
#include <ESP8266HTTPClient.h>
WiFiClient wificlient;
const char* ssid = "xxxxxxxxx" ; //"SU-SSID" ;
const char* clave = "xxxxxxx" ; //"SU-CLAVE" ;
const char* usuario = "ArielArguello" ; //"USUARIO IDENTIFICADOR" ;

#define RST_PIN 5 // declaro las constantes
#define SS_PIN 4 // declaro las constantes
MFRC522 mfrc522(SS_PIN, RST_PIN);

void setup() {
  Serial.begin(9600);    // inicializo comunicacvion serial con la PC



  SPI.begin();      // Inicializo el buss spi
  mfrc522.PCD_Init();   // inicio modulo lector

  WiFi.hostname("Name");
  WiFi.begin(ssid, clave);

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println("");
  Serial.println("WiFi connected");

  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());
}


void loop() {

  if ( ! mfrc522.PICC_IsNewCardPresent()) {
    return;
  }

  if ( ! mfrc522.PICC_ReadCardSerial()) {
    return;
  }

  String tarj = "";

  for (byte i = 0; i < mfrc522.uid.size; i++) {

    if (mfrc522.uid.uidByte[i] < 0x10) {
      tarj += "0";
    }

    //    if (i + 1 != mfrc522.uid.size) {
    //      tarj += " ";
    //    }

    tarj += String(mfrc522.uid.uidByte[i], HEX);

  }
  tarj.toUpperCase();
  if (tarj) {
    Serial.print(tarj);
  }
  mfrc522.PICC_HaltA();
  HTTPClient http;

  http.begin(wificlient, "http://bartoflesh.000webhostapp.com/api-tomadatos.php?tarjeta=" + tarj);

  int httpCode = http.GET();

  if (httpCode > 0) {

    String respuestadelapagina = http.getString();
    Serial.println(respuestadelapagina);
  }
  http.end();



}
