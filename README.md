# Travel Payouts PHP SDK

### Usage example

###Composer

```
composer require thewulf7/travel-payouts
```
or add to your composer.json file, in the "require" section
```
"thewulf7/travel-payouts": "1.1.*"
```

##Usage

 First of all create main Travel object and pass your token in it 
```php
use thewulf7\travelPayouts\Travel; 

$travel = new Travel('YOUR TOKEN HERE');
```
Then you can use it get different services

###Tickets service
```php
$ticketService = $travel->getTicketService();
//Get flights found by our users in the last 48 hours from LED to MOW. Return array consists of thewulf7\travelPayouts\Ticket objects.
$flights = $ticketService->getLatestPrices('LED', 'MOW', false, 'rub', 'year', 1, 10);
```
