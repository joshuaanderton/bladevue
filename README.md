🚨 ***PACKAGE IS STILL IN EARLY DEVELOPMENT (PRE-V1)*** 🚨

# Bladevue - Vue-infused blade components for Laravel

## Variables and properies
Basically, all you need to do is stop using...
```
{{ $voldemort }}
```

and start using...
```
${ voldemort }
```

## Loops
Loops are different in Bladevue as well. Instead of...
```
@foreach($horcrux as $horcrux)
  // Do something with the $horcrux (aka destroy it?)
@endforeach
```

You'll use the Vue (more specifically, Petite Vue) default...
```
<li v-for="horcrux in horcruxes">
  // Destroy that horcrux!
</li>
```
