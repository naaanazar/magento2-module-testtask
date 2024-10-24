<div align="center">
  <img src="https://img.shields.io/badge/magento-2.X-brightgreen.svg?logo=magento&longCache=true" alt="Supported Magento Versions" />
</div>
# Magento2 module TestTask

## GraphQL query examples

### Get Attribute Hobby options
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

### Update Hobby attribute
```

mutation {
  updateHobby(input: { hobby: "[optionId]" }) {
    hobby
  }
}
```

### Get Attribute Hobby text value
```
{
  customer {
    hobby
  }
}
```
