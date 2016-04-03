# Travel Payouts PHP SDK

## Installation

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
$ticketService = $travel->getTicketsService();
//Get flights found by our users in the last 48 hours from LED to MOW. Return array consists of thewulf7\travelPayouts\Ticket objects.
$flights = $ticketService->getLatestPrices('LED', 'MOW', false, 'rub', 'year', 1, 10);
```

See [documentation](https://github.com/thewulf7/travel-payouts/wiki/TicketService)

###Flight service
```php
$flightService = $travel->getFlightService();
$flightService
       ->setIp('127.0.0.1')
       ->setHost('aviasales.ru')
       ->setMarker('123')
       ->addPassenger('adults', 2)
       ->addSegment('LED', 'MOW', '2016-02-01');
$searchData    = $flightService->search('ru', 'Y');
$searchResults = $flightService->getSearchResults($searchData['search_id']);
```

###Partner service
```php
$partnerService = $travel->getPartnerService();
//get user balance and currency of the balance
list($balance, $currency) = $partnerService->getBalance();
```

###Data service
```php
$dataService = $travel->getDataService();
//get all airports in the system
$airports    = $dataService->getAirports(); 
```

