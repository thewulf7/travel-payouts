# Travel Payouts PHP SDK

### Usage example

```php
$travel = new Travel('YOUR TOKEN HERE');

$ticketsService = $travel->getTicketsService();

$routes = $ticketsService->getPopularRoutesFromCity('LAX');
```
