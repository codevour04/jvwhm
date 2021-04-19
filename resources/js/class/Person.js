export default class Person {
 
    constructor(fname, mname, lname, leader, address, bdate, city, contact_number) 
    {
      this.firstname = fname;
      this.middlename = mname;
      this.lastname = lname;
      this.leader = leader;
      this.address = address;
      this.birthdate = bdate;
      this.city = city;
      this.contact_number = contact_number;
    }   

    getGivenName()
    {
      return this.firstName;
    }

    getMiddleName()
    {
      return this.middleName;
    }

    getLastName()
    {
      return this.lastName;
    }

    getAddress()
    {
      return this.address;
    }

    getLeader()
    {
      return this.leader;
    }

    getCity()
    {
      return this.city;
    }

    getBirthDate()
    {
      return this.birthdate;
    }
}