package com.app.kostpink;

import android.content.Context;
import android.content.SharedPreferences;
import android.util.Log;

import com.app.kostpink.model.Customer;
import com.app.kostpink.model.User;


public class SharedPrefManager {

    private static String SHARED_PREF_NAME = "afapedia";
    Context context;
    private SharedPreferences sharedPreferences;
    private SharedPreferences.Editor editor;


    public SharedPrefManager(Context context) {
        this.context = context;
    }

    public void saveCustomer(Customer customer) {
        Log.d("customer", "savecustomer: " + customer);
        sharedPreferences = context.getSharedPreferences(SHARED_PREF_NAME, Context.MODE_PRIVATE);
        editor = sharedPreferences.edit();
        editor.putString("id_customer", customer.getId_customer());
        editor.putString("nama_customer", customer.getNama_customer());
        editor.putString("email", customer.getEmail());
        editor.putString("telepon", customer.getTelepon());
        editor.putString("alamat", customer.getAlamat());
        editor.putString("tanggal_lahir", customer.getTanggal_lahir());
        editor.putString("username", customer.getUsername());
        editor.putString("password", customer.getPassword());
        editor.putString("avatar", customer.getAvatar());
        editor.putString("status", customer.getStatus());
        editor.putBoolean("logged", true);
        editor.putBoolean("customer",true);


        editor.apply();
    }

    public void saveUser(User user) {
        Log.d("user", "saveuser: " + user);
        sharedPreferences = context.getSharedPreferences(SHARED_PREF_NAME, Context.MODE_PRIVATE);
        editor = sharedPreferences.edit();
        editor.putString("id_user", user.getId_user());
        editor.putString("nama", user.getNama());
        editor.putString("email", user.getEmail());
           editor.putString("username", user.getUsername());
        editor.putString("password", user.getPassword());
        editor.putString("avatar", user.getAvatar());
        editor.putString("status", user.getStatus());
        editor.putBoolean("logged", true);
        editor.putBoolean("customer",false);

        editor.apply();
    }


    public boolean isLoggedIn() {
        sharedPreferences = context.getSharedPreferences(SHARED_PREF_NAME, Context.MODE_PRIVATE);
        return sharedPreferences.getBoolean("logged", false);
    }

    public boolean isCustomer(){
        sharedPreferences=context.getSharedPreferences(SHARED_PREF_NAME,Context.MODE_PRIVATE);
        return sharedPreferences.getBoolean("customer",false);
    }

    public Customer getCustomer() {
        sharedPreferences = context.getSharedPreferences(SHARED_PREF_NAME, Context.MODE_PRIVATE);
        return new Customer(
                sharedPreferences.getString("id_customer", null),
                sharedPreferences.getString("nama_customer", null),
                sharedPreferences.getString("email", null),
                sharedPreferences.getString("telepon", null),
                sharedPreferences.getString("alamat", null),
                sharedPreferences.getString("tanggal_lahir", null),
                sharedPreferences.getString("username", null),
                sharedPreferences.getString("password", null),
                sharedPreferences.getString("avatar", null),
                sharedPreferences.getString("status", null)
        );
    }

    public User getUser() {
        sharedPreferences = context.getSharedPreferences(SHARED_PREF_NAME, Context.MODE_PRIVATE);
        return new User(
                sharedPreferences.getString("id_user", null),
                sharedPreferences.getString("nama", null),
                sharedPreferences.getString("email", null),
                sharedPreferences.getString("username", null),
                sharedPreferences.getString("password", null),
                sharedPreferences.getString("avatar", null),
                sharedPreferences.getString("status", null)
        );
    }

    public void logout() {
        sharedPreferences = context.getSharedPreferences(SHARED_PREF_NAME, Context.MODE_PRIVATE);
        editor = sharedPreferences.edit();
        editor.clear();
        editor.apply();

    }
}
