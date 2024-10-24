<div align="center">
  <img src="https://img.shields.io/badge/magento-2.X-brightgreen.svg?logo=magento&longCache=true" alt="Supported Magento Versions" />
</div>

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
