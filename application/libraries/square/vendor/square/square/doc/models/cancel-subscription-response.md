
# Cancel Subscription Response

Defines output parameters in a response from the
[CancelSubscription](../../doc/apis/subscriptions.md#cancel-subscription) endpoint.

## Structure

`CancelSubscriptionResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Errors encountered during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `subscription` | [`?Subscription`](../../doc/models/subscription.md) | Optional | Represents a subscription to a subscription plan by a subscriber.<br><br>For an overview of the `Subscription` type, see<br>[Subscription object](https://developer.squareup.com/docs/subscriptions-api/overview#subscription-object-overview). | getSubscription(): ?Subscription | setSubscription(?Subscription subscription): void |
| `actions` | [`?(SubscriptionAction[])`](../../doc/models/subscription-action.md) | Optional | A list of a single `CANCEL` action scheduled for the subscription. | getActions(): ?array | setActions(?array actions): void |

## Example (as JSON)

```json
{
  "subscription": {
    "canceled_date": "2021-10-20",
    "card_id": "ccof:qy5x8hHGYsgLrp4Q4GB",
    "created_at": "2021-10-20T21:53:10Z",
    "customer_id": "CHFGVKYY8RSV93M5KCYTG4PN0G",
    "id": "910afd30-464a-4e00-a8d8-2296eEXAMPLE",
    "location_id": "S8GWD5R9QB376",
    "paid_until_date": "2021-11-20",
    "plan_id": "6JHXF3B2CW3YKHDV4XEM674H",
    "source": {
      "name": "My App"
    },
    "start_date": "2021-10-20",
    "status": "ACTIVE",
    "timezone": "America/Los_Angeles",
    "version": 1594311617331
  },
  "errors": [
    {
      "category": "AUTHENTICATION_ERROR",
      "code": "REFUND_ALREADY_PENDING",
      "detail": "detail1",
      "field": "field9"
    },
    {
      "category": "INVALID_REQUEST_ERROR",
      "code": "PAYMENT_NOT_REFUNDABLE",
      "detail": "detail2",
      "field": "field0"
    },
    {
      "category": "RATE_LIMIT_ERROR",
      "code": "REFUND_DECLINED",
      "detail": "detail3",
      "field": "field1"
    }
  ],
  "actions": [
    {
      "id": "id9",
      "type": "PAUSE",
      "effective_date": "effective_date1",
      "new_plan_id": "new_plan_id5"
    },
    {
      "id": "id0",
      "type": "CANCEL",
      "effective_date": "effective_date0",
      "new_plan_id": "new_plan_id6"
    },
    {
      "id": "id1",
      "type": "SWAP_PLAN",
      "effective_date": "effective_date9",
      "new_plan_id": "new_plan_id7"
    }
  ]
}
```

