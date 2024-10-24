## Magento2 module TestTask

### GraphQL query examples

#### Get attribute hobby options
```
{
  customAttributeMetadata(
    attributes: [
      {
        attribute_code: "hobby"
        entity_type: "customer"
      }
    ]
  ) {
    items {
      attribute_options {
       value
       label
     }
    }
  }
}
```

#### Update hobby attribute
```

mutation {
  updateHobby(input: { hobby: "[optionId]" }) {
    hobby
  }
}
```

#### Get attribute hobby text value
```
{
  customer {
    hobby
  }
}
```
