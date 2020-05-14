var user={
	name: 'Andrés',
	last_name:'Chaparro'
}

var user2={
	name: 'Andrés',
	last_name:'Chaparro'
}

db.users.insertOne(user)

db.users.insertMany([
	user2,user3
])

db.users.find({
	name:"Andrés"
},
{
	_id:true
}).pretty()

db.users.find({
	name:{
		$ne: "Andrés"
	}
})

db.users.findOne({
	name:"Andrés"
})
// $e == 
// $ne !=
// $gt >
// $gte >=
// $lt <
// $lte >=
// $and
// $or

db.users.find({
	$and:[
		{
			age:{$gt:20}
		},
		{
			age:{lt:26}
		}
	]
})

// like

db.books.find({
	title:/^El/
})

db.books.find({
	title:/s$/
})

db.books.find({
	title: /la/
})

//  $in:[,,,]
// $nin

db.users.find({
	last_name:  {
		$exist:true
	}
})

db.users.find({
	createdAr:  {
		$type: 'date'
	}
})


// Double 'double'
// String 'string'
// Object 'Object'
// Array 'array'
// Objectid 'objectid'
// Boolean 'boolean'
// Date 'date'
// Null 'null'
// Regular expression 'regex'
// Timestamp 'timestamp'

var aux= db.users.findOne({name:'Andrés'})
aux.name='Felipe'
db.users.save(aux)
//updateOne
// $unset
//$inc
db.users.updateMany({
	support:{
		$exists: false
	}
},
{
	$set:{
		support:false
	}
})

db.users.updateOne(
	{
		upsert:true
	}
)

db.users.remove({
	name:'Luis'
})

//drop
//dropDatabase

//findAndModify

for(i=0;i<100;i++){
	db.demo.insert({
		name:'user'+i
	})
}

//pretty()
//count()
//limit()
//skip()
//sort()

db.users.findAndModify({
	query:{
		name:'Andres'
	},
	update:{
		$inc:{
			age: -1
		}
	},
	new: true
})

db.users.updateMany({},{
	$rename:{
		last_name:'lastName'
	}
})